<?php
/**
 * Adminhtml dashboard tab abstract
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */

abstract class Mage_Adminhtml_Block_Dashboard_Abstract extends Mage_Adminhtml_Block_Widget
{
    protected $_dataHelperName = null;

    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function getCollection()
    {
           return $this->getDataHelper()->getCollection();
    }

    public function getCount()
    {
           return $this->getDataHelper()->getCount();
    }

    public function getDataHelper()
    {
           return $this->helper($this->getDataHelperName());
    }

    public  function getDataHelperName()
    {
           return $this->_dataHelperName;
    }

    public  function setDataHelperName($dataHelperName)
    {
           $this->_dataHelperName = $dataHelperName;
           return $this;
    }

    protected function _prepareData()
    {
        return $this;
    }

    protected function _prepareLayout()
    {
        $this->_prepareData();
        return parent::_prepareLayout();
    }
}
