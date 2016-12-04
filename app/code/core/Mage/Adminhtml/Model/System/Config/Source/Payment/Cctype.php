<?php


class Mage_Adminhtml_Model_System_Config_Source_Payment_Cctype
{
    public function toOptionArray()
    {
        $options =  array();

        foreach (Mage::getSingleton('payment/config')->getCcTypes() as $code => $name) {
            $options[] = array(
               'value' => $code,
               'label' => $name
            );
        }

        return $options;
    }
}
