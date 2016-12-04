<?php



class Mage_Adminhtml_Model_System_Config_Source_Design_Robots
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'INDEX,FOLLOW', 'label'=>'INDEX, FOLLOW'),
            array('value'=>'NOINDEX,FOLLOW', 'label'=>'NOINDEX, FOLLOW'),
            array('value'=>'INDEX,NOFOLLOW', 'label'=>'INDEX, NOFOLLOW'),
            array('value'=>'NOINDEX,NOFOLLOW', 'label'=>'NOINDEX, NOFOLLOW'),
        );
    }
}
