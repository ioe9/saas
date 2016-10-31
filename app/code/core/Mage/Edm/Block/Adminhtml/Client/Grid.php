<?php
class Mage_Edm_Block_Adminhtml_Client_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('urlprocessGrid');
        $this->setDefaultSort('urlprocess_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/company_client')->getCollection();
        $collection->addFieldToFilter('company_id',Mage::registry('current_company')->getId());
        $collection->getSelect()
        	->join(array('c'=>'edm_client'),'main_table.client_id=c.client_id',array('name','website','country'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => "客户名称",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'name',
        ));
		
        $this->addColumn('website', array(
            'header'    => "客户官网",
            'align'     => 'center',
            'index'     => 'website'
        ));
        $this->addColumn('contact_person', array(
            'header'    => "联系人",
            'align'     => 'center',
            'index'     => 'contact_person'
        ));
        $this->addColumn('contact_email', array(
            'header'    => "联系邮箱",
            'align'     => 'center',
            'index'     => 'contact_email'
        ));
        $this->addColumn('country', array(
            'header'    => "所在国家",
            'align'     => 'center',
            'index'     => 'country'
        ));
        $this->addColumn('date_create', array(
            'header'    => "加入时间",
            'align'     => 'center',
            'index'     => 'date_create'
        ));
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'no_link'   => true,
            'width'		=> '160px',
            'renderer'	=>	'edm/adminhtml_urlprocess_renderer_action'
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
