<?php
/**
 * Config edit page
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_System_Config_Edit extends Mage_Adminhtml_Block_Widget
{
    const DEFAULT_SECTION_BLOCK = 'adminhtml/system_config_form';

    protected $_section;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('system/config/edit.phtml');

        $sectionCode = $this->getRequest()->getParam('section');
        $sections = Mage::getSingleton('adminhtml/config')->getSections();

        $this->_section = $sections->$sectionCode;

        $this->setTitle((string)$this->_section->label);
        $this->setHeaderCss((string)$this->_section->header_css);
    }

    protected function _prepareLayout()
    {
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Save Config'),
                    'onclick'   => 'configForm.submit()',
                    'class' => 'save',
                ))
        );
        return parent::_prepareLayout();
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current'=>true));
    }

    public function initForm()
    {
        /*
        $this->setChild('dwstree',
            $this->getLayout()->createBlock('adminhtml/system_config_dwstree')
                ->initTabs()
        );
        */

        $blockName = (string)$this->_section->frontend_model;
        if (empty($blockName)) {
            $blockName = self::DEFAULT_SECTION_BLOCK;
        }
        $this->setChild('form',
            $this->getLayout()->createBlock($blockName)
                ->initForm()
        );
        return $this;
    }


}
