<?php
/**
 * Order Statuses source model
 */
class Mage_Adminhtml_Model_System_Config_Source_Order_Status_Newprocessing extends Mage_Adminhtml_Model_System_Config_Source_Order_Status
{
    protected $_stateStatuses = array(
        Mage_Sales_Model_Order::STATE_NEW,
        Mage_Sales_Model_Order::STATE_PROCESSING
    );
}
