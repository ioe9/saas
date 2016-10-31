<?php
class Mage_Edm_Block_Adminhtml_Company_Client_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/company_client_category')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('category_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'category_id',
        ));
		
        $this->addColumn('name', array(
            'header'    => "名称",
            'align'     => 'center',
            'index'     => 'name'
        ));
        $this->addColumn('desc', array(
            'header'    => "描述",
            'align'     => 'left',
            'index'     => 'desc'
        ));
        $this->addColumn('parent_id', array(
            'header'    => "父分组ID",
            'index'     => 'parent_id',
        ));
        $this->addColumn('position', array(
            'header'    => '排序',
            'align'     => 'center',
            'index'     => 'position',
            'width'     => '50px',
        ));

        $this->addColumn('action',
            array(
                'header'    => "操作",
                'width'     => '80px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => "编辑",
                        'url'     => array(
                            'base'=>'*/*/edit',
                            
                        ),
                        'field'   => 'id'
                    )
                ),
                'align'     => 'center',
                'filter'    => false,
                'sortable'  => false,
        ));
        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
       
        parent::_afterLoadCollection();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
