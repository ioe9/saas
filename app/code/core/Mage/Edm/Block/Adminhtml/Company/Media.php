<?php
class Mage_Edm_Block_Adminhtml_Company_Media extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_company_media';
    	$this->_blockGroup = 'edm';
		$this->_headerText = "图片管理";
        parent::__construct();
        
        
    }
}
