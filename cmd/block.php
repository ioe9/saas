<html>
<head>
	<title>快速创建Block - grid+edit</title>
</head>
<body>
<form action="" method="POST">
	<p>Module Code:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="module" />
	<p>Block Code:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="block_name" />
	<p>Block Header Text:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="header_text" />
	<p>Block New Text:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="new_text" />
	<p><input style="border:1px solid #DDD;padding:2px 10px;background:#CCC;line-height:22px;" type="submit" value="submit" />
</form>
</body>
</html>
<?php
/*
 * 自动生成Model文件
 *
 */
if (isset($_POST['module']) && trim($_POST['module']) && $_POST['block_name']) {
	$module = trim($_POST['module']);
	$blockName = trim($_POST['block_name']);
	$header_text = trim($_POST['header_text']);
	$new_text = trim($_POST['new_text']);
	$dir = "../app/code/core/Mage/".ucwords($module)."/Block";
	if (!is_dir($dir)) {
		mkdir($dir);
	}
	
	$dirBlockAdminhtml = "../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml";
	mkdir($dirBlockAdminhtml);
	
	$dirBlock = "../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml/".ucwords($blockName);
	mkdir($dirBlock);
	
	$dirBlockEdit = "../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml/".ucwords($blockName).'/Edit';
	mkdir($dirBlockEdit);
	
	//Create File
	$fileGridContainer = fopen("../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml/".ucwords($blockName).".php",'w+');
	fwrite($fileGridContainer,'<?php
class Mage_'.ucwords($module).'_Block_Adminhtml_'.ucwords($blockName).' extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = "adminhtml_'.$blockName.'";
    	$this->_blockGroup = "'.$module.'";
		$this->_headerText = "'.$header_text.'";
        parent::__construct();
        $this->_updateButton("add", "label", "<i class=\'fa fa-plus-circle mr5\'></i>'.$new_text.'");
    }
}
');
	$fileGrid = fopen("../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml/".ucwords($blockName)."/Grid.php",'w+');
	fwrite($fileGrid,'<?php
class Mage_'.ucwords($module).'_Block_Adminhtml_'.ucwords($blockName).'_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("'.$blockName.'Grid");
        $this->setDefaultSort("'.$blockName.'_id");
        $this->setDefaultDir("desc");
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("'.$module.'/'.$blockName.'")->getCollection();
        $collection->addFieldToFilter("'.$blockName.'_company",Mage::registry("current_company")->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("'.$blockName.'_code", array(
            "header"    => "编号",
            "align"     => "center",
            "width"     => "140px",
            "index"     => "'.$blockName.'_code",
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return;
    }

}

');
	
	$fileEdit = fopen("../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml/".ucwords($blockName)."/Edit.php",'w+');
	fwrite($fileEdit,'<?php
class Mage_'.ucwords($module).'_Block_Adminhtml_'.ucwords($blockName).'_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId   = "'.$blockName.'_id";
        $this->_controller = "adminhtml_'.$blockName.'";
    	$this->_blockGroup = "'.$module.'";
        parent::__construct();
        $this->_addButton("saveandcontinue", array(
                "label"     => "<i class=\'fa fa-save mr5\'></i>保存并继续",
                "onclick"   => "saveAndContinueEdit()",
                "class"     => "btn btn-primary save",
            ), -100);
       $this->_formScripts[] = "
	            function saveAndContinueEdit(){
	                editForm.submit($(\'edit_form\').action+\'back/edit/\');
	            }
	           
	        ";
       $this->setTemplate("widget/form/container_fieldgroup.phtml");
    }

    public function getHeaderText()
    {
        if (Mage::registry("current_'.$blockName.'")->getId()) {
            return "编辑";
        } else {
            return "新建";
        }
    }
}
');	
	
	$fileEditForm = fopen("../app/code/core/Mage/".ucwords($module)."/Block/Adminhtml/".ucwords($blockName)."/Edit/Form.php",'w+');
	fwrite($fileEditForm,'<?php
class Mage_'.ucwords($module).'_Block_Adminhtml_'.ucwords($blockName).'_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
        	"id"=>"edit_form",
        	"action"=>$this->getUrl("*/*/save"),
        	"method"=>"POST",
        ));
        
		$model = Mage::registry("current_'.$blockName.'");
		$data = $model->getData();
		
        $fieldgroup   = $form->addFieldgroup("base_fieldgroup", array(
            "legend"    => "基本信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $tr = $fieldgroup->addField("tr_base", array(
            "class"    => "",
        ));
        if ($model->getId()) {
			$tr->addField("id", "hidden", array(
	            "name"      => "id",
	        ));
		}
        $tr->addField("id_1", "text", array(
            "name"      => "id_1",
            "label"     => "ID_1",
            "required"  => true,
        ));

        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

');	
	
} 