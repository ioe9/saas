<?php


class Mage_Adminhtml_Block_Cache extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_controller = 'cache';
        $this->_headerText = Mage::helper('core')->__('Cache Storage Management');
        parent::__construct();
        $this->_removeButton('add');
        $this->_addButton('flush_magento', array(
            'label'     => Mage::helper('core')->__('Flush Magento Cache'),
            'onclick'   => 'setLocation(\'' . $this->getFlushSystemUrl() .'\')',
            'class'     => 'delete',
        ));

        $confirmationMessage = Mage::helper('core')->jsQuoteEscape(
            Mage::helper('core')->__('Cache storage may contain additional data. Are you sure that you want flush it?')
        );
        $this->_addButton('flush_system', array(
            'label'     => Mage::helper('core')->__('Flush Cache Storage'),
            'onclick'   => 'confirmSetLocation(\'' . $confirmationMessage . '\', \'' . $this->getFlushStorageUrl()
                . '\')',
            'class'     => 'delete',
        ));
    }

    /**
     * Get url for clean cache storage
     */
    public function getFlushStorageUrl()
    {
        return $this->getUrl('*/*/flushAll');
    }

    /**
     * Get url for clean cache storage
     */
    public function getFlushSystemUrl()
    {
        return $this->getUrl('*/*/flushSystem');
    }
}
