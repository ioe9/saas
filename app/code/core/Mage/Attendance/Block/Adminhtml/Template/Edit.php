<?php
class Mage_Attendance_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
    	$this->setTemplate('attendance/email/template/edit.phtml');
        parent::__construct();
    }

    
	public function getModuleCollection() {
		$collection = Mage::getResourceModel('attendance/templates_module_collection')
			->setOrder('position','desc');
		return $collection;
	}

}