<?php
class Mage_Edm_Block_Adminhtml_Design_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('designGrid');
        $this->setDefaultSort('design_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/template_design')->getCollection();
        if (Mage::registry('current_filter')=='my') {
        	$collection->addFieldToFilter('design_company',Mage::registry('current_company')->getId());
        } elseif (Mage::registry('current_filter')=='wishlist') {
        	$collection->getSelect()
        		->join(array('w'=>"edm_template_wishlist"),'w.wishlist_object=main_table.design_id',array('date_create as wdate','wishlist_type'));
        	$collection->addFieldToFilter('wishlist_type',Mage_Edm_Model_Template_Wishlist::TYPE_DESIGN);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('design_id', array(
            'header'    => "编号",
            'align'     => 'center',
            'width'     => '65px',
            'index'     => 'design_id',
        ));
        $this->addColumn('design_scene', array(
            'header'    => "使用场景",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'design_scene',
           
        ));
        $this->addColumn('design_title', array(
            'header'    => "标题",
            'align'     => 'center',
            'index'     => 'design_title',
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
                'index'     =>'design_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'align'     => 'center',
                'width'	   => '100px',
                'renderer' => 'edm/adminhtml_design_renderer_action'
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
