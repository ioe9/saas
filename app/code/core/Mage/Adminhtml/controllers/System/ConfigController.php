<?php
class Mage_Adminhtml_System_ConfigController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Whether current section is allowed
     *
     * @var bool
     */
    protected $_isSectionAllowedFlag = true;

    /**
     * Controller predispatch method
     * Check if current section is found and is allowed
     *
     * @return Mage_Adminhtml_System_ConfigController
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if ($this->getRequest()->getParam('section')) {
            $this->_isSectionAllowedFlag = $this->_isSectionAllowed($this->getRequest()->getParam('section'));
        }

        return $this;
    }

    /**
     * Index action
     *
     */
    public function indexAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit configuration section
     *
     */
    public function editAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Configuration'));

        $current = $this->getRequest()->getParam('section');

        Mage::getSingleton('adminhtml/config_data')
            ->setSection($current);

        $configFields = Mage::getSingleton('adminhtml/config');

        $sections     = $configFields->getSections($current);
        $section      = $sections->$current;
        $hasChildren  = $configFields->hasChildren($section);
        if (!$hasChildren && $current) {
            $this->_redirect('*/*/');
        }

        $this->loadLayout();

        $this->_setActiveMenu('system/config');
        $this->getLayout()->getBlock('menu')->setAdditionalCacheKeyInfo(array($current));

        $this->getLayout()->getBlock('left')
            ->append($this->getLayout()->createBlock('adminhtml/system_config_tabs')->initTabs());
		
        if ($this->_isSectionAllowedFlag) {
            $this->_addContent($this->getLayout()->createBlock('adminhtml/system_config_edit')->initForm());
            $this->_addJs($this->getLayout()
                ->createBlock('adminhtml/template')
                ->setTemplate('system/config/js.phtml'));
      
            $this->renderLayout();
        }
    }

    /**
     * Save configuration
     *
     */
    public function saveAction()
    {
        $session = Mage::getSingleton('adminhtml/session');
        /* @var $session Mage_Adminhtml_Model_Session */

        $groups = $this->getRequest()->getPost('groups');

        if (isset($_FILES['groups']['name']) && is_array($_FILES['groups']['name'])) {
            /**
             * Carefully merge $_FILES and $_POST information
             * None of '+=' or 'array_merge_recursive' can do this correct
             */
            foreach($_FILES['groups']['name'] as $groupName => $group) {
                if (is_array($group)) {
                    foreach ($group['fields'] as $fieldName => $field) {
                        if (!empty($field['value'])) {
                            $groups[$groupName]['fields'][$fieldName] = array('value' => $field['value']);
                        }
                    }
                }
            }
        }

        try {
            if (!$this->_isSectionAllowed($this->getRequest()->getParam('section'))) {
                throw new Exception(Mage::helper('adminhtml')->__('This section is not allowed.'));
            }

            // custom save logic
            $this->_saveSection();
            $section = $this->getRequest()->getParam('section');
            Mage::getSingleton('adminhtml/config_data')
                ->setSection($section)
                ->setGroups($groups)
                ->save();

            // reinit configuration
            Mage::getConfig()->reinit();
            Mage::dispatchEvent('admin_system_config_section_save_after', array(
                'section' => $section
            ));
            // website and store codes can be used in event implementation, so set them as well
            Mage::dispatchEvent("admin_system_config_changed_section_{$section}",
                array()
            );
            $session->addSuccess(Mage::helper('adminhtml')->__('The configuration has been saved.'));
        }
        catch (Mage_Core_Exception $e) {
            foreach(explode("\n", $e->getMessage()) as $message) {
                $session->addError($message);
            }
        }
        catch (Exception $e) {
            $session->addException($e,
                Mage::helper('adminhtml')->__('An error occurred while saving this configuration:') . ' '
                . $e->getMessage());
        }

        $this->_saveState($this->getRequest()->getPost('config_state'));

        $this->_redirect('*/*/edit', array('_current' => array('section')));
    }

    /**
     *  Custom save logic for section
     */
    protected function _saveSection ()
    {
        $method = '_save' . uc_words($this->getRequest()->getParam('section'), '');
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    /**
     *  Advanced save procedure
     */
    protected function _saveAdvanced()
    {
        Mage::app()->cleanCache(
            array(
                'layout',
                Mage_Core_Model_Layout_Update::LAYOUT_GENERAL_CACHE_TAG
            ));
    }

    /**
     * Save fieldset state through AJAX
     *
     */
    public function stateAction()
    {
        if ($this->getRequest()->getParam('isAjax') == 1
                    && $this->getRequest()->getParam('container') != ''
                        && $this->getRequest()->getParam('value') != '') {

            $configState = array(
                $this->getRequest()->getParam('container') => $this->getRequest()->getParam('value')
            );
            $this->_saveState($configState);
            $this->getResponse()->setBody('success');
        }
    }

    /**
     * Export shipping table rates in csv format
     *
     */
    public function exportTableratesAction()
    {
        $fileName   = 'tablerates.csv';
        /** @var $gridBlock Mage_Adminhtml_Block_Shipping_Carrier_Tablerate_Grid */
        $gridBlock  = $this->getLayout()->createBlock('adminhtml/shipping_carrier_tablerate_grid');
        $website    = Mage::app()->getWebsite($this->getRequest()->getParam('website'));
        if ($this->getRequest()->getParam('conditionName')) {
            $conditionName = $this->getRequest()->getParam('conditionName');
        } else {
            $conditionName = $website->getConfig('carriers/tablerate/condition_name');
        }
        $gridBlock->setWebsiteId($website->getId())->setConditionName($conditionName);
        $content    = $gridBlock->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check is allow modify system configuration
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config');
    }

    /**
     * Check if specified section allowed in ACL
     *
     * Will forward to deniedAction(), if not allowed.
     *
     * @param string $section
     * @return bool
     */
    protected function _isSectionAllowed($section)
    {
        try {
            $session = Mage::getSingleton('admin/session');
            $resourceLookup = "admin/system/config/{$section}";
            if ($session->getData('acl') instanceof Mage_Admin_Model_Acl) {
                $resourceId = $session->getData('acl')->get($resourceLookup)->getResourceId();
                if (!$session->isAllowed($resourceId)) {
                    throw new Exception('');
                }
                return true;
            }
        }
        catch (Zend_Acl_Exception $e) {
            $this->norouteAction();
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        catch (Exception $e) {
            $this->deniedAction();
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
    }

    /**
     * Save state of configuration field sets
     *
     * @param array $configState
     * @return bool
     */
    protected function _saveState($configState = array())
    {
        $adminUser = Mage::getSingleton('admin/session')->getUser();
        if (is_array($configState)) {
            $extra = $adminUser->getExtra();
            if (!is_array($extra)) {
                $extra = array();
            }
            if (!isset($extra['configState'])) {
                $extra['configState'] = array();
            }
            foreach ($configState as $fieldset => $state) {
                $extra['configState'][$fieldset] = $state;
            }
            $adminUser->saveExtra($extra);
        }

        return true;
    }
}
