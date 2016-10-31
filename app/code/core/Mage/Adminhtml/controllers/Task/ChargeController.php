<?php
/***
 * 我负责的任务
 */
class Mage_Adminhtml_Task_ChargeController extends Mage_Adminhtml_Controller_Task_Task {
	protected $_title = "我负责的任务";
	public function preDispatch() {
        Mage::register('current_filter','charge',true);
        parent::preDispatch();
        return $this;
	}
}