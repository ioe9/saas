<?php



class Mage_Adminhtml_Model_System_Config_Source_Email_Smtpauth
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'NONE', 'label'=>'NONE'),
            array('value'=>'PLAIN', 'label'=>'PLAIN'),
            array('value'=>'LOGIN', 'label'=>'LOGIN'),
            array('value'=>'CRAM-MD5', 'label'=>'CRAM-MD5'),
        );
    }
}
