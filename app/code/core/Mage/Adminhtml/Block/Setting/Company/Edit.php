<?php
class Mage_Adminhtml_Block_Setting_Company_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_controller = 'setting_company';
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('保存信息'));
        $this->_removeButton('delete');
        $this->_removeButton('back');
        $this->_removeButton('reset');
    }

    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('企业信息设置');
    }
}
