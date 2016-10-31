<?php
/***
 * 我负责的项目
 */
class Mage_Adminhtml_Task_Project_ChargeController extends Mage_Adminhtml_Controller_Task_Project {
	protected $_title = "我负责的项目";
	public function preDispatch() {
        Mage::register('current_filter','charge',true);
        parent::preDispatch();
        return $this;
	}
}