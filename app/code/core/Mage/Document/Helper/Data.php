<?php
class Mage_Document_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_dirPath = 'companys';
	protected $_documentPath = 'document';
    public function getCompanyDocumentRoot($companyId = null)
    {
    	if (!$companyId) {
    		$companyId = Mage::registry('current_company')->getId();
    	}
        return Mage::getBaseDir('media').DS.$this->_dirPath.DS.$companyId.DS.$this->_documentPath.DS;
    }
    public function getAllowExt() {
    	$dicts = $this->getExtDict();
    	$arr = array();
    	foreach ($dicts as $key=>$key) {
    		$arr = array_merge($arr,$key);
    	}
    	return $arr;
    }
    public function getExtDict() {
    	$dict = array(
			'pic'=>array('.png','.bmp','.jpg','.jpeg','.tiff','.gif','.pcx','.tga','.exif','.fpx','.svg','.cdr','.pcd','.dxf','.ufo','.eps','.ai','.raw'),
			'doc'=>array('.doc','.docx','.docm','.dot','.dotx','.dotm'),
			'xsl'=>array('.xls','.xlsx','.xlsm','.xltx','.xltm','.xlsb','.xlam'),
			'ppt'=>array('.ppt','.pptx','.pptm','.ppsx','.ppsx','.potx','.potm','.ppam'),
			'music'=>array('.wav','.aif','.au','.mp3','.ram','.wma','.mmf','.amr','.aac','.flac','.ra','mid'),
			'zip'=>array('.zip','.rar','.gz','.z','.arj'),
			'video'=>array('.avi','.rmvb','.swf','.rm','.asf','.divx','.mpg','.mpeg','.mpe','.wmv','.mp4','.mkv','.vob'),
			'dll'=>array('.dll'),
			'html'=>array('.htm','.html'),
			'pdf'=>array('.pdf'),
			'txt'=>array('.txt')
		);
    	return $dict;
    }
    
    public function getExt($ext) {
    	$dicts = $this->getExtDict();
    	foreach ($dicts as $key=>$arr) {
    		if (in_array($ext,$arr)) {
    			return $key;
    		}
    	}
    	return 'default';
    }
}
