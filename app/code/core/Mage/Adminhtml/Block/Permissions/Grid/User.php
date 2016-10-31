<?php
class Mage_Adminhtml_Block_Permissions_Grid_User extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('customerGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('username');
        $this->setDefaultDir('asc');
    }

    protected function _prepareCollection()
    {
        $collection =  Mage::getModel("permissions/users")->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('user_id', array(
            'header'    =>Mage::helper('adminhtml')->__('ID'),
            'width'     =>5,
            'align'     =>'right',
            'sortable'  =>true,
            'index'     =>'user_id'
        ));
        $this->addColumn('username', array(
            'header'    =>Mage::helper('adminhtml')->__('User Name'),
            'index'     =>'username'
        ));
        $this->addColumn('firstname', array(
            'header'    =>Mage::helper('adminhtml')->__('First Name'),
            'index'     =>'firstname'
        ));
        $this->addColumn('lastname', array(
            'header'    =>Mage::helper('adminhtml')->__('Last Name'),
            'index'     =>'lastname'
        ));
        $this->addColumn('email', array(
            'header'    =>Mage::helper('adminhtml')->__('Email'),
            'width'     =>40,
            'align'     =>'left',
            'index'     =>'email'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edituser', array('id' => $row->getUserId()));
    }

}

