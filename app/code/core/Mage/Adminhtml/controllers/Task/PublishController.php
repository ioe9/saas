<?php
/***
 * 我发布的任务
 */
class Mage_Adminhtml_Task_PublishController extends Mage_Adminhtml_Controller_Task_Task {
	protected $_title = "我发布的任务";
	public function preDispatch() {
        Mage::register('current_filter','publish',true);
        parent::preDispatch();
        return $this;
	}
}