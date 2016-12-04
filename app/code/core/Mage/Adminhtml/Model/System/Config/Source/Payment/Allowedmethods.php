<?php


class Mage_Adminhtml_Model_System_Config_Source_Payment_Allowedmethods
    extends Mage_Adminhtml_Model_System_Config_Source_Payment_Allmethods
{
    protected function _getPaymentMethods()
    {
        return Mage::getSingleton('payment/config')->getActiveMethods();
    }

//    public function toOptionArray()
//    {
//        $methods = array(array('value'=>'', 'label'=>''));
//        $payments = Mage::getSingleton('payment/config')->getActiveMethods();
//        foreach ($payments as $paymentCode=>$paymentModel) {
//            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
//            $methods[$paymentCode] = array(
//                'label'   => $paymentTitle,
//                'value' => $paymentCode,
//            );
//        }
//
//        return $methods;
//    }
}
