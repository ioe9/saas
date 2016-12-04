<html>

<body>
<form action="" method="POST">
	<p>Module Name:</p>
	<p><input style="border:1px solid #ddd;padding:2px 5px;line-height:30px;" type="text" name="module" />
	<p>Models Name:</p>
	<p><textarea style="border:1px solid #ddd;padding:2px 5px;height:200px;" name="auto"></textarea>
	<p><input style="border:1px solid #DDD;padding:2px 10px;background:#CCC;line-height:22px;" type="submit" value="submit" />
</form>
</body>
</html>
<?php
/*
 * 自动生成Model文件
 *
 */
if (isset($_POST['auto']) && trim($_POST['auto'])) {
	$module = trim($_POST['module']);
	$models = explode("\n",trim($_POST['auto']));
	foreach ($models as $item) {
		$item = trim($item);
		if (strstr($item,'_')) {
			$arr = explode('_',$item);
			$prefix = $arr[0];
			$suffix = $arr[1];
			$dir = "../app/code/core/Mage/".ucwords($module)."/Model/".ucwords($prefix);
			if (!is_dir($dir)) {
				mkdir($dir);
			}
			
			
			$file = fopen("../app/code/core/Mage/".ucwords($module)."/Model/".ucwords($prefix)."/".ucwords($suffix).'.php','w+');
		fwrite($file,'<?php
class Mage_'.ucwords($module).'_Model_'.ucwords($prefix).'_'.ucwords($suffix).' extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("'.$module.'/'.$prefix.'_'.$suffix.'");
    }
	
}
');
		$dir = "../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($prefix);
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		
		$file = fopen("../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($prefix)."/".ucwords($suffix).'.php','w+');
		fwrite($file,'<?php
class Mage_'.ucwords($module).'_Model_Resource_'.ucwords($prefix).'_'.ucwords($suffix).' extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("'.$module.'/'.$prefix.'_'.$suffix.'","'.$suffix.'_id");
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton("core/date")->gmtDate());
        }
        return parent::_beforeSave($object);
    }

}

');
		$dir = "../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($prefix).'/'.ucwords($suffix);
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		
		$file = fopen("../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($prefix).'/'.ucwords($suffix).'/Collection.php','w');
		fwrite($file,'<?php
class Mage_'.ucwords($module).'_Model_Resource_'.ucwords($prefix).'_'.ucwords($suffix).'_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("'.$module.'/'.$prefix.'_'.$suffix.'");
    }
}
');
/***********************************************分隔**********************************************/
		} else {
			$file = fopen("../app/code/core/Mage/".ucwords($module)."/Model/".ucwords($item).'.php','w+');
		fwrite($file,'<?php
class Mage_'.ucwords($module).'_Model_'.ucwords($item).' extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("'.$module.'/'.$item.'");
    }
	
}
');
		$file = fopen("../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($item).'.php','w+');
		fwrite($file,'<?php
class Mage_'.ucwords($module).'_Model_Resource_'.ucwords($item).' extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("'.$module.'/'.$item.'","'.$item.'_id");
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton("core/date")->gmtDate());
        }
        return parent::_beforeSave($object);
    }

}

');
		$dir = "../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($item);
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		$file = fopen("../app/code/core/Mage/".ucwords($module)."/Model/Resource/".ucwords($item).'/Collection.php','w+');
		fwrite($file,'<?php
class Mage_'.ucwords($module).'_Model_Resource_'.ucwords($item).'_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("'.$module.'/'.$item.'");
    }
}
');
		}
		
	}
} 