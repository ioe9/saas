<?php
class Mage_Edm_Block_Adminhtml_Company_Client_Email_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('emailGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/company_client_email')->getCollection();
        $collection->addFieldToFilter('email_company',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
		$this->addColumn('email_client', array(
            'header'    => "所属客户",
            'align'     => 'center',
            'index'     => 'email_client'
        ));
        $this->addColumn('email', array(
            'header'    => "邮箱地址",
            'align'     => 'left',
            'index'     => 'email'
        ));
        $this->addColumn('firstname', array(
            'header'    => "First Name",
            'align'     => 'center',
            'index'     => 'firstname'
        ));
        $this->addColumn('lastname', array(
            'header'    => "Last Name",
            'align'     => 'center',
            'index'     => 'lastname'
        ));
        $this->addColumn('telephone', array(
            'header'    => "联系电话",
            'align'     => 'left',
            'index'     => 'telephone'
        ));
        $this->addColumn('memo', array(
            'header'    => "备忘",
            'align'     => 'left',
            'index'     => 'memo'
        ));
        $this->addColumn('date_latest', array(
            'header'    => "上次发件时间",
            'align'     => 'center',
            'index'     => 'date_latest'
        ));
        $this->addColumn('date_create', array(
            'header'    => "录入时间",
            'index'     => 'date_create',
            'align'     => 'center',
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
