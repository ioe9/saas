<?php
class Mage_Document_Model_Dir_Link extends Mage_Core_Model_Abstract
{
	const LINK_TYPE_DEPT = 0;
	const LINK_TYPE_USER = 1;
    protected function _construct()
    {
        $this->_init("document/dir_link");
    }
	
		
	/***
	 * 获取目录关联人
	 */
	public function getDirLink($dirId,$type = self::LINK_TYPE_DEPT) {
		$collection = $this->getCollection()
			->addFieldToFilter('link_type',$type)
			->addFieldToFilter('link_dir',$dirId);
		$collection->getSelect()
	    		->joinLeft(
	    			array('u'=>'saas_admin_user'),
					'main_table.link_object=u.user_id',
					array('name')
				);
	}
	
	public function getDeptChooserSelected($dirId) {
		$collection = Mage::getModel('admin/department')->getCollection();
		$collection->getSelect()
				->join(
	    			array('link'=>'document_dir_link'),
					'link.link_object=main_table.department_id',
					array('link_type','link_dir')
				);
		$collection->addFieldToFilter('link_dir',$dirId);
		
		$data = array();
		foreach ($collection as $item) {
			$tmp = array(
	    		'id' => $item['deparment_id'],
	    		'name' => $item['dep_name'],
	    		'icon' => $item['dep_avatar'] ? $item['dep_avatar'] : Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'adminhtml/default/default/images/avatar/avatar_l.png',
	    		'type' => '2',
	    	);
			array_push($data,$tmp);
		}
		return $data;
	    		
	} 
	
	public function getUserChooserSelected($dirId) {
		$collection = Mage::getModel('admin/user')->getUserByCompany();
		$collection->getSelect()
				->join(
	    			array('link'=>'document_dir_link'),
					'link.link_object=main_table.user_id',
					array('link_type','link_dir')
				);
		$collection->addFieldToFilter('link_dir',$dirId);
		$collection->addFieldToFilter('link_type',self::LINK_TYPE_USER);
		
		$data = array();
		foreach ($collection as $item) {
			$tmp = array(
	    		'id' => $item['user_id'],
	    		'name' => $item['name'],
	    		'icon' => $item['user_avatar'] ? $item['user_avatar'] : Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'adminhtml/default/default/images/avatar/avatar_l.png',
	    		'type' => '3',
	    	);
			array_push($data,$tmp);
		}
		return $data;
	    		
	} 
}
