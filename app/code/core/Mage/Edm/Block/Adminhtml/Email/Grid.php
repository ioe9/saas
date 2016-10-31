<?php
class Mage_Edm_Block_Adminhtml_Email_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('emailGrid');
        $this->setDefaultSort('email_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/newsletters')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('newsletterid', array(
            'header'    => 'ID',
            'align'     => 'center',
            'index'     => 'newsletterid',
            'type'  => 'number',
            'width'     => '40px',
        ));

		$this->addColumn('name', array(
            'header'    => '邮件标题',
            'align'     => 'center',
            'index'     => 'name',
        ));
        
        
        
        $this->addColumn('count_success', array(
            'header'    => '成功',
            'align'     => 'center',
            'index'     => 'count_success',
        ));
        
        $this->addColumn('count_fail', array(
            'header'    => '失败',
            'align'     => 'center',
            'index'     => 'count_fail',
        ));
        
        $this->addColumn('count_open', array(
            'header'    => '打开',
            'align'     => 'center',
            'index'     => 'count_open',
        ));
        
        $this->addColumn('count_click', array(
            'header'    => '点击',
            'align'     => 'center',
            'index'     => 'count_click',
        ));
        
        $this->addColumn('count_unsub', array(
            'header'    => '退订',
            'align'     => 'center',
            'index'     => 'count_unsub',
        ));
        $this->addColumn('senddate', array(
            'header'    => '下次发送时间',
            'align'     => 'center',
            'index'     => 'senddate',
        ));
		
		$this->addColumn('finishdate', array(
            'header'    => '上次发送时间',
            'align'     => 'center',
            'index'     => 'finishdate',
        ));
        $this->addColumn('name', array(
            'header'    => '创建时间',
            'align'     => 'center',
            'index'     => 'name',
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
