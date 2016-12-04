<?php
class Mage_Edm_Block_Adminhtml_Template_Module_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('itemGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
		if (Mage::registry('use_my_filter')) {	
        	$collection = Mage::getResourceModel('edm/company_template_module_item_collection');
        	$collection->addFieldToFilter('item_company',Mage::registry('current_company')->getId());
        	$collection->addFieldToFilter('item_module',$this->getModule()->getId());
		} else {
			$collection = Mage::getResourceModel('edm/template_module_item_collection');
			$collection->addFieldToFilter('module_id',$this->getModule()->getId());
		}
		
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
		/*
        $this->addColumn('item_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'item_id',
        ));*/
		
        $this->addColumn('item_content', array(
            'header'    => "内容",
            'align'     => 'left',
            'index'     => 'item_content',
            
        ));
        
		if (Mage::registry('use_my_filter')) {	
	        $this->addColumn('action',
	            array(
	                'header'    =>  "操作",
	                'width'     => '120px',
	                'type'      => 'action',
	                'align'     => 'center',
	                'getter'    => 'getId',
	                'actions'   => array(
	                    array(
	                        'caption'   => "禁用",
	                        'url'       => array('base'=> '*/*/itemdisable'),
	                        'field'     => 'id'
	                    ),
	                    array(
	                        'caption'   => "删除",
	                        'url'       => array('base'=> '*/*/itemdelete'),
	                        'field'     => 'id'
	                    )
	                ),
	                'filter'    => false,
	                'sortable'  => false,
	                'is_system' => true,
	        ));
		} else {
			$this->addColumn('action',
	            array(
	                'header'    =>  "操作",
	                'width'     => '120px',
	                'type'      => 'action',
	                'align'     => 'center',
	                'getter'    => 'getId',
	                'actions'   => array(
	                    array(
	                        'caption'   => "禁用",
	                        'url'       => array('base'=> '*/*/itemdisable'),
	                        'field'     => 'id'
	                    ),
	                ),
	                'filter'    => false,
	                'sortable'  => false,
	                'is_system' => true,
	        ));
		}

        return parent::_prepareColumns();
    }


    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl2($row)
    {
        return;
    }
    
    public function getModule() {
    	return Mage::registry('current_module');
    }

}
