<?php
class Mage_Adminhtml_Block_Cache_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_invalidatedTypes = array();
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('cache_grid');
        $this->_filterVisibility = false;
        $this->_pagerVisibility  = false;
        $this->_invalidatedTypes = Mage::app()->getCacheInstance()->getInvalidatedTypes();
    }

    /**
     * Prepare grid collection
     */
    protected function _prepareCollection()
    {
        $collection = new Varien_Data_Collection();
        foreach (Mage::app()->getCacheInstance()->getTypes() as $type) {
            $collection->addItem($type);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add name and description to collection elements
     */
    protected function _afterLoadCollection()
    {
        foreach ($this->_collection as $item) {
        }
        return $this;
    }

    /**
     * Prepare grid columns
     */
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        $this->addColumn('cache_type', array(
            'header'    => $this->__('Cache Type'),
            'width'     => '180',
            'align'     => 'left',
            'index'     => 'cache_type',
            'sortable'  => false,
        ));

        $this->addColumn('description', array(
            'header'    => $this->__('Description'),
            'align'     => 'left',
            'index'     => 'description',
            'sortable'  => false,
        ));

        $this->addColumn('tags', array(
            'header'    => $this->__('Associated Tags'),
            'align'     => 'left',
            'index'     => 'tags',
            'width'     => '180',
            'sortable'  => false,
        ));

        $this->addColumn('status', array(
            'header'    => $this->__('Status'),
            'width'     => '120',
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(0 => $this->__('Disabled'), 1 => $this->__('Enabled')),
            'frame_callback' => array($this, 'decorateStatus')
        ));

        return parent::_prepareColumns();
    }

    /**
     * Decorate status column values
     *
     * @return string
     */
    public function decorateStatus($value, $row, $column, $isExport)
    {
        $class = '';
        if (isset($this->_invalidatedTypes[$row->getId()])) {
            $cell = '<span class="grid-severity-minor"><span>'.$this->__('Invalidated').'</span></span>';
        } else {
            if ($row->getStatus()) {
                $cell = '<span class="grid-severity-notice"><span>'.$value.'</span></span>';
            } else {
                $cell = '<span class="grid-severity-critical"><span>'.$value.'</span></span>';
            }
        }
        return $cell;
    }

    /**
     * Get row edit url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }

    /**
     * Add mass-actions to grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('types');
        $this->getMassactionBlock()->addItem('enable', array(
            'label'         => Mage::helper('core')->__('Enable'),
            'url'           => $this->getUrl('*/*/massEnable'),
        ));
        $this->getMassactionBlock()->addItem('disable', array(
            'label'    => Mage::helper('core')->__('Disable'),
            'url'      => $this->getUrl('*/*/massDisable'),
        ));
        $this->getMassactionBlock()->addItem('refresh', array(
            'label'    => Mage::helper('core')->__('Refresh'),
            'url'      => $this->getUrl('*/*/massRefresh'),
            'selected' => true,
        ));

        return $this;
    }
}
