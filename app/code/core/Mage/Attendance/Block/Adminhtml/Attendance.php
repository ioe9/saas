<?php
class Mage_Attendance_Block_Adminhtml_Attendance extends Mage_Adminhtml_Block_Template
{
	protected $_pageSize = 20;
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('attendance/attendance.phtml');
    }
    
    protected function _prepareLayout(){
        parent::_prepareLayout();
       
        return $this;
         
    }
}
