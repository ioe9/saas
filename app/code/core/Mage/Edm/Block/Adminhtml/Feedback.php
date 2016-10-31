<?php
class Mage_Edm_Block_Adminhtml_Feedback extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_feedback';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "反馈提交记录";
    	//$this->_updateButton(array(''))
        parent::__construct();
        $this->_updateButton('add', 'label', "我要提交反馈信息");
        
    }
}
