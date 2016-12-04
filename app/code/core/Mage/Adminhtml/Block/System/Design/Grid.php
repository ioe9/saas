<?php
/**
 * Design changes grid
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_System_Design_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('designGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare grid data collection
     *
     * @return Mage_Adminhtml_Block_System_Design_Grid
     */
    protected function _prepareCollection()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);

        $collection = Mage::getResourceModel('core/design_collection');

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * Define grid columns
     *
     * @return Mage_Adminhtml_Block_System_Design_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('package', array(
                'header'    => Mage::helper('catalog')->__('Design'),
                'width'     => '150px',
                'index'     => 'design',
        ));
        $this->addColumn('date_from', array(
            'header'    => Mage::helper('catalogrule')->__('Date From'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'date',
            'index'     => 'date_from',
        ));

        $this->addColumn('date_to', array(
            'header'    => Mage::helper('catalogrule')->__('Date To'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'date',
            'index'     => 'date_to',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Prepare row click url
     *
     * @param Varien_Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Prepare grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

}
