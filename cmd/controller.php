<html>
<head>
	<title>快速创建模块</title>
</head>
<body>
<form action="" method="POST">
	<p>Module Code:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="module" />
	<p>Module Name:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="module_name" />
	<p><input style="border:1px solid #DDD;padding:2px 10px;background:#CCC;line-height:22px;" type="submit" value="submit" />
</form>
</body>
</html>
<?php
/*
 * 自动生成Model文件
 *
 */
if (isset($_POST['module']) && trim($_POST['module'])) {
	$module = trim($_POST['module']);
	$moduleName = trim($_POST['module_name']);
	$dir = "../app/code/core/Mage/".ucwords($module);
	if (!is_dir($dir)) {
		mkdir($dir);
	} else {
		echo "Allready Existed!"; die();
	}
	$dirModel = "../app/code/core/Mage/".ucwords($module)."/Model";
	mkdir($dirModel);
	
	$dirModelResource = "../app/code/core/Mage/".ucwords($module)."/Model/Resource";
	mkdir($dirModelResource);
	
	$dirBlock = "../app/code/core/Mage/".ucwords($module)."/Block";
	mkdir($dirBlock);
	
	$dirEtc = "../app/code/core/Mage/".ucwords($module)."/etc";
	mkdir($dirEtc);
	
	$dirHelper = "../app/code/core/Mage/".ucwords($module)."/Helper";
	mkdir($dirHelper);
	
	//Adminhtml
	$dirAdminhtmlController = "../app/code/core/Mage/Adminhtml/controllers/".ucwords($module);
	mkdir($dirAdminhtmlController);
	
	//Create File
	$fileEtcConfig = fopen("../app/code/core/Mage/".ucwords($module)."/etc/config.xml",'w+');
		fwrite($fileEtcConfig,'<?xml version="1.0"?>
<config>
    <global/>
</config>
');
	$fileEtcMenu = fopen("../app/code/core/Mage/".ucwords($module)."/etc/adminhtml.xml",'w+');
		fwrite($fileEtcMenu,'<?xml version="1.0"?>
<config>
    <menu>
        <'.$module.'>
        	<sort_order>990</sort_order>
	        <title>'.$moduleName.'</title>
	        <type>trade</type>
	        <action>adminhtml/'.$module.'/</action>
	        <children>
		        <index>
		        	<sort_order>0</sort_order>
			        <title>首页</title>
			        <action>adminhtml/'.$module.'/index</action>
		        </index>
	        </children>
        </'.$module.'>
    </menu>
</config>
');

	$fileHelperData = fopen("../app/code/core/Mage/".ucwords($module)."/Helper/Data.php",'w+');
		fwrite($fileHelperData,'<?php
class Mage_'.ucwords($module).'_Helper_Data extends Mage_Core_Helper_Abstract
{
	

}
');
$fileControlerIndex = fopen("../app/code/core/Mage/Adminhtml/controllers/".ucwords($module)."Controller.php",'w+');
		fwrite($fileControlerIndex,'<?php
/***
 * 
 */
class Mage_Adminhtml_'.ucwords($module).'Controller extends Mage_Adminhtml_Controller_'.ucwords($module).'
{
    public function indexAction()
    {
        $this->_title($this->__("'.$moduleName.'"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}
');

$fileControlerIndex = fopen("../app/code/core/Mage/Adminhtml/Controller/".ucwords($module).".php",'w+');
		fwrite($fileControlerIndex,'<?php
/***
 * 
 */
class Mage_Adminhtml_Controller_'.ucwords($module).' extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName("'.$moduleName.'");
        $app->setCode("'.$module.'");
        Mage::register("current_app",$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	if (strpos($menuPath,"'.$module.'")!==0) {
    		$menuPath = "'.$module.'/".$menuPath;
    	}
    	$this->getLayout()->getBlock("navigation")->setActive($menuPath);
        $this->getLayout()->getBlock("menu")->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton("admin/session")->isAllowed("'.$module.'");
    }
}

');
		
$fileNote = fopen("../app/code/core/Mage/".ucwords($module)."/note.txt",'w+');
		fwrite($fileNote,'');
} 