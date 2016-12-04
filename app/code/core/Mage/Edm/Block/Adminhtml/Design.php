<?php
class Mage_Edm_Block_Adminhtml_Design extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_design';
    	$this->_blockGroup = 'edm';
    	if (Mage::registry('current_filter')=='my') {
			$this->_headerText = "我的主题";
    	} else if (Mage::registry('current_filter')=='wishlist') {
    		$this->_headerText = "我的收藏";
    	}
        parent::__construct();
        $this->_updateButton('add', 'label', '<i class="fa fa-plus-circle mr5"></i>'."创建主题");
        
    }
    
    public function getWide() {
    	return true;
    }
}
