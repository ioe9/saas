<?php
/**
 * Adminhtml urlrewrite grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Urlrewrite_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('urlrewriteGrid');
        $this->setDefaultSort('url_rewrite_id');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('core/url_rewrite_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('url_rewrite_id', array(
            'header'    => $this->__('ID'),
            'width'     => '50px',
            'index'     => 'url_rewrite_id'
        ));

        $this->addColumn('is_system', array(
            'header'    =>$this->__('Type'),
            'width'     => '50px',
            'index'     => 'is_system',
            'type'      => 'options',
            'options'   => array(
                1 => $this->__('System'),
                0 => $this->__('Custom')
            ),
        ));

        $this->addColumn('id_path', array(
            'header'    => $this->__('ID Path'),
            'width'     => '50px',
            'index'     => 'id_path'
        ));
        $this->addColumn('request_path', array(
            'header'    => $this->__('Request Path'),
            'width'     => '50px',
            'index'     => 'request_path'
        ));
        $this->addColumn('target_path', array(
            'header'    => $this->__('Target Path'),
            'width'     => '50px',
            'index'     => 'target_path'
        ));
        $this->addColumn('options', array(
            'header'    => $this->__('Options'),
            'width'     => '50px',
            'index'     => 'options'
        ));
        $this->addColumn('actions', array(
            'header'    => $this->__('Action'),
            'width'     => '15px',
            'sortable'  => false,
            'filter'    => false,
            'type'      => 'action',
            'actions'   => array(
                array(
                    'url'       => $this->getUrl('*/*/edit') . 'id/$url_rewrite_id',
                    'caption'   => $this->__('Edit'),
                ),
            )
        ));
        //$this->addExportType('*/*/exportCsv', $this->__('CSV'));
        //$this->addExportType('*/*/exportXml', $this->__('XML'));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
        //return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }

}

