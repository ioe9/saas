<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * System configuration tabs block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_System_Config_Tabs extends Mage_Adminhtml_Block_Widget
{

    /**
     * Tabs
     *
     * @var array
     */
    protected $_tabs;

    /**
     * Enter description here...
     *
     */
    protected function _construct()
    {
        $this->setId('system_config_tabs');
        $this->setTitle(Mage::helper('adminhtml')->__('Configuration'));
        $this->setTemplate('system/config/tabs.phtml');
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $a
     * @param unknown_type $b
     * @return int
     */
    protected function _sort($a, $b)
    {
        return (int)$a->sort_order < (int)$b->sort_order ? -1 : ((int)$a->sort_order > (int)$b->sort_order ? 1 : 0);
    }

    /**
     * Enter description here...
     *
     */
    public function initTabs()
    {
        $current = $this->getRequest()->getParam('section');
      
        $url = Mage::getModel('adminhtml/url');

        $configFields = Mage::getSingleton('adminhtml/config');
        $sections = $configFields->getSections($current);
        $tabs     = (array)$configFields->getTabs()->children();
		

        $sections = (array)$sections;

        usort($sections, array($this, '_sort'));
        usort($tabs, array($this, '_sort'));

        foreach ($tabs as $tab) {
            $helperName = $configFields->getAttributeModule($tab);
            $label = Mage::helper($helperName)->__((string)$tab->label);

            $this->addTab($tab->getName(), array(
                'label' => $label,
                'class' => (string) $tab->class
            ));
        }

		

        foreach ($sections as $section) {
            Mage::dispatchEvent('adminhtml_block_system_config_init_tab_sections_before', array('section' => $section));
            $hasChildren = $configFields->hasChildren($section);
            //$code = $section->getPath();
            $code = $section->getName();

            $sectionAllowed = $this->checkSectionPermissions($code);
            if ((empty($current) && $sectionAllowed)) {

                $current = $code;
                $this->getRequest()->setParam('section', $current);
            }

            $helperName = $configFields->getAttributeModule($section);

            $label = Mage::helper($helperName)->__((string)$section->label);
            //var_dump($hasChildren);
            //$hasChildren = true;
            if ( $sectionAllowed && $hasChildren) {
                $this->addSection($code, (string)$section->tab, array(
                    'class'     => (string)$section->class,
                    'label'     => $label,
                    'url'       => $url->getUrl('*/*/*', array('_current'=>true, 'section'=>$code)),
                ));
            }

            if ($code == $current) {
                $this->setActiveTab($section->tab);
                $this->setActiveSection($code);
            }
        }

        /*
         * Set last sections
         */
        foreach ($this->getTabs() as $tab) {
            $sections = $tab->getSections();
            if ($sections) {
                $sections->getLastItem()->setIsLast(true);
            }
        }

        Mage::helper('adminhtml')->addPageHelpUrl($current.'/');
		
        return $this;
    }

    public function addTab($code, $config)
    {
        $tab = new Varien_Object($config);
        $tab->setId($code);
        $this->_tabs[$code] = $tab;
        return $this;
    }

    /**
     * Retrive tab
     *
     * @param string $code
     * @return Varien_Object
     */
    public function getTab($code)
    {
        if(isset($this->_tabs[$code])) {
            return $this->_tabs[$code];
        }

        return null;
    }

    public function addSection($code, $tabCode, $config)
    {

        if($tab = $this->getTab($tabCode)) {
            if(!$tab->getSections()) {
                $tab->setSections(new Varien_Data_Collection());
            }
            $section = new Varien_Object($config);
            $section->setId($code);
            $tab->getSections()->addItem($section);
        }
        return $this;
    }

    public function getTabs()
    {
        return $this->_tabs;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getStoreButtonsHtml()
    {
      

        $html = '';
        $html .= $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => Mage::helper('adminhtml')->__('Edit Store View'),
            'onclick'   => "location.href='".$this->getUrl('*/system_store/edit')."'",
        ))->toHtml();
        $html .= $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => Mage::helper('adminhtml')->__('Delete Store View'),
            'onclick'   => "location.href='".$this->getUrl('*/system_store/delete')."'",
            'class'     => 'delete',
        ))->toHtml();


        return $html;
    }

    /**
     * Enter description here...
     *
     * @param string $code
     * @return boolean
     */
    public function checkSectionPermissions($code=null)
    {
        static $permissions;

        if (!$code or trim($code) == "") {
            return false;
        }

        if (!$permissions) {
            $permissions = Mage::getSingleton('admin/session');
        }

        $showTab = false;
        if ( $permissions->isAllowed('system/config/'.$code) ) {
            $showTab = true;
        }
        return $showTab;
    }

}
