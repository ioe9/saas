<?php
/***
 * 其他项目
 */
class Mage_Adminhtml_Task_Project_OtherController extends Mage_Adminhtml_Controller_Task_Project {
	protected $_title = "其他项目";
	public function preDispatch() {
        Mage::register('current_filter','other',true);
        parent::preDispatch();
        return $this;
	}
}