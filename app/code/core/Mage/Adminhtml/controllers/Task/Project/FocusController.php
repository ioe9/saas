<?php
/***
 * 我关注的项目
 */
class Mage_Adminhtml_Task_Project_FocusController extends Mage_Adminhtml_Controller_Task_Project {
	protected $_title = "我关注的项目";
	public function preDispatch() {
        Mage::register('current_filter','focus',true);
        parent::preDispatch();
        return $this;
	}
}