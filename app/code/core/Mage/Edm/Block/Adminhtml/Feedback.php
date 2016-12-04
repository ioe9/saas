<?php
class Mage_Edm_Block_Adminhtml_Feedback extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_feedback';
    	$this->_blockGroup = 'edm';
    	if (Mage::registry('current_filter')=='my') {
			$this->_headerText = "我提交的反馈";
    	} else {
    		$this->_headerText = "反馈列表";
    	}
    	//$this->_updateButton(array(''))
        parent::__construct();
        $this->_updateButton('add', 'label', '<i class="fa fa-plus-circle mr5"></i>'."我要提交反馈");
        
    }
}
