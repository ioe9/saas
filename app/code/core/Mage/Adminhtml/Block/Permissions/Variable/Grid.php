<?php
/**
 * Adminhtml permissions variable grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Permissions_Variable_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('permissionsVariableGrid');
        $this->setDefaultSort('variable_id');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        /** @var Mage_Admin_Model_Resource_Variable_Collection $collection */
        $collection = Mage::getResourceModel('admin/variable_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('variable_id', array(
            'header'    => Mage::helper('adminhtml')->__('ID'),
            'width'     => 5,
            'align'     => 'right',
            'sortable'  => true,
            'index'     => 'variable_id'
        ));
        $this->addColumn('variable_name', array(
            'header'    => Mage::helper('adminhtml')->__('Variable'),
            'index'     => 'variable_name'
        ));
        $this->addColumn('is_allowed', array(
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'index'     => 'is_allowed',
            'type'      => 'options',
            'options'   => array(
                '1' => Mage::helper('adminhtml')->__('Allowed'),
                '0' => Mage::helper('adminhtml')->__('Not allowed')),
            )
        );

        parent::_prepareColumns();
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('variable_id' => $row->getId()));
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/variableGrid', array());
    }
}
