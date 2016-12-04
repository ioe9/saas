<?php
/**
 * Order Statuses source model
 */
class Mage_Adminhtml_Model_System_Config_Source_Order_Status_New extends Mage_Adminhtml_Model_System_Config_Source_Order_Status
{
    protected $_stateStatuses = Mage_Sales_Model_Order::STATE_NEW;
}
