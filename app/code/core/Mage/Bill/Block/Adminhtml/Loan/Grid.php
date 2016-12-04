<?php
class Mage_Bill_Block_Adminhtml_Loan_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("loanGrid");
        $this->setDefaultSort("loan_id");
        $this->setDefaultDir("desc");
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("bill/loan")->getCollection();
        $collection->addFieldToFilter("loan_company",Mage::registry("current_company")->getId());
        $collection->addFieldToFilter("loan_create",Mage::registry("current_user")->getId());
      	
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn("loan_code", array(
            "header"    => "单号",
            "align"     => "center",
            "width"     => "140px",
            "index"     => "loan_code",
        ));
		
       
      
		 $this->addColumn("loan_create", array(
            "header"    => "申请人",
            "align"     => "center",
            "width"     => "70px",
            "index"     => "name",
            "filter"    => false,
        ));
		$this->addColumn("loan_department", array(
            "header"    => "部门",
            "align"     => "center",
            "width"     => "100px",
            "index"     => "loan_department",
            
        ));   
	    
        $this->addColumn("date_create", array(
            "header"    => "申请时间",
            "align"     => "center",
            "width"     => "140px",
            "index"     => "date_create",
            "filter"    => false,
        ));
        $this->addColumn("loan_type", array(
            "header"    => "借款类型",
            "align"     => "center",
            "width"     => "100px",
            "index"     => "loan_type",
            "type"      => "options",
            "options"   => Mage::getSingleton("bill/loan")->getTypeOptions(),
        ));   
        
        $this->addColumn("total_bill", array(
            "header"    => "借款金额",
            "align"     => "right",
            "width"     => "80px",
            "index"     => "total_bill",
            "filter"    => false,
        ));
        $this->addColumn("loan_status", array(
            "header"    => "单据状态",
            "align"     => "center",
            "width"     => "100px",
            "index"     => "loan_status",
            "type"      => "options",
            "options"   => Mage::getSingleton("bill/loan")->getStatusOptions(),
        )); 
        //当前审批
        $this->addColumn("rem_create", array(
            "header"    => "当前审批",
            "align"     => "right",
            "width"     => "120px",
            "index"     => "rem_create",
            "filter"    => false,
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return;
    }

}
