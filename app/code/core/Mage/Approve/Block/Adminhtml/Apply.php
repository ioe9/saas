<?php
class Mage_Approve_Block_Adminhtml_Apply extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_apply';
    	$this->_blockGroup = 'approve';
    	$filter = Mage::registry('current_filter');
    	if ($filter=='todo'){
    		$this->_headerText = "我的待办";
    	} else if ($filter=='ccto') {
    		$this->_headerText = "抄送给我";
    	} else if ($filter=='done') {
    		$this->_headerText = "我的已办";
    	}
		
    	
        parent::__construct();
        
        $this->_updateButton('add', 'label', "+ 新建申请");
    }
}
