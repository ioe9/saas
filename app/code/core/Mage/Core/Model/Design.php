<?php
class Mage_Core_Model_Design extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('core/design');
    }

    public function validate()
    {
        $this->getResource()->validate($this);
        return $this;
    }
}
