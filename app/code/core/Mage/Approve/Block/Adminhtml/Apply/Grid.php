<?php
class Mage_Approve_Block_Adminhtml_Apply_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('applyGrid');
        $this->setDefaultSort('apply_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('approve/apply')->getCollection();
        $collection->addFieldToFilter('apply_company',Mage::registry('current_company')->getId());
      	$filter = Mage::registry('current_filter');
      	
    	if ($filter=='todo' || $filter=='ccto'){
    		//
    		$collection->getSelect()
	    		->joinLeft(
	    			array('u'=>'saas_admin_user'),
					'main_table.apply_create=u.user_id',
					array('name')
				);
    		
    	} else if ($filter=='done') {
    		$collection->getSelect()
	    		->joinLeft(
	    			array('u'=>'saas_admin_user'),
					'main_table.apply_create=u.user_id',
					array('name')
				);
    	}
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('apply_code', array(
            'header'    => "单号",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'apply_code',
        ));
		

        $filter = Mage::registry('current_filter');
    	if ($filter=='todo' || $filter=='ccto'){
    		$this->addColumn('name', array(
	            'header'    => "申请人",
	            'align'     => 'center',
	            'width'     => '100px',
	            'index'     => 'name',
	        ));
    		
    	} else if ($filter=='submit') {
    		$this->addColumn('name', array(
	            'header'    => "审批人",
	            'align'     => 'center',
	            'width'     => '100px',
	            'index'     => 'name',
	        ));
    	}
	       
        
        $this->addColumn('apply_department', array(
            'header'    => "部门",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'apply_department',
            
            'type'      => 'options',
            'options'   => Mage::getModel('admin/department')->getAsOptions(),
        ));
        $this->addColumn('apply_template', array(
            'header'    => "申请类型",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'apply_template',
            'type'      => 'options',
            'options'   => Mage::getModel('approve/template')->getAsOptions(),
        ));
        
        $this->addColumn('apply_status', array(
            'header'    => "状态",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'apply_status',
            'type'      => 'options',
            'options'   => Mage::getModel('approve/apply')->getStatusOptions(),
        ));
        $this->addColumn('date_create', array(
            'header'    => "申请时间",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'date_create',
            'filter'    => false,
        ));
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'align'     => 'center',
            'no_link'   => true,
            'width'		=> '160px',
            'renderer'	=>	'approve/adminhtml_apply_renderer_action'
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
