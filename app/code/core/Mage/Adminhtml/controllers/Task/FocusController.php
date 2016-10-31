<?php
/***
 * 我关注的任务
 */
class Mage_Adminhtml_Task_FocusController extends Mage_Adminhtml_Controller_Task_Task {
	protected $_title = "我关注的任务";
	public function preDispatch() {
        Mage::register('current_filter','focus',true);
        parent::preDispatch();
        return $this;
	}
}