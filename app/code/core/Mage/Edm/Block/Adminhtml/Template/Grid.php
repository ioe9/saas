<?php
class Mage_Edm_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('templateGrid');
        $this->setDefaultSort('template_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/template')->getCollection();
        if (Mage::registry('current_filter')=='my') {
        	$collection->addFieldToFilter('template_company',Mage::registry('current_company')->getId());
        } elseif (Mage::registry('current_filter')=='wishlist') {
        	$collection->getSelect()
        		->join(array('w'=>"edm_template_wishlist"),'w.wishlist_object=main_table.template_id',array('date_create as wdate','wishlist_type'));
        	$collection->addFieldToFilter('wishlist_type',Mage_Edm_Model_Template_Wishlist::TYPE_DESIGN);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('template_id', array(
            'header'    => "编号",
            'align'     => 'center',
            'width'     => '65px',
            'index'     => 'template_id',
        ));
        $this->addColumn('template_scene', array(
            'header'    => "使用场景",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'template_scene',
           
        ));
        $this->addColumn('template_title', array(
            'header'    => "标题",
            'align'     => 'center',
            'index'     => 'template_title',
            'width'     => '250px',
            'sortable' => false,
        ));
        
       
        $this->addColumn('date_create', array(
            'header'    => "录入时间",
            'index'     => 'date_create',
            'width'     => '100px',
            'filter' => false,
            'align'     => 'center',
            'renderer' => 'edm/adminhtml_renderer_date'
        ));
		$this->addColumn('action',
            array(
                'header'    => "操作",
                'index'     =>'template_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'align'     => 'center',
                'width'	   => '100px',
                'renderer' => 'edm/adminhtml_template_renderer_action'
        ));
        return parent::_prepareColumns();
    }


    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return;
    }

}
