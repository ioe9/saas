<?php
class Mage_Edm_Model_Import
{
	protected function _getReadConnect() {
		return Mage::getSingleton('core/resource')->getConnection('core_read');
	}
	protected function _getWriteConnect() {
		return Mage::getSingleton('core/resource')->getConnection('core_write');
	}
	
	public function importValidateEmail($emails,$position,$user_id=0) {
		$edmertSql = "INSERT INTO `edm_email_validate`(`email`,`position`,`user_id`) VALUES ";
		$tmp = array();
		if (count($emails)) {
			foreach ($emails as $_email) {
				$tmpSql = "('".trim($_email)."','$position','$user_id')";
				array_push($tmp,$tmpSql);
			}
			$edmertSql = $edmertSql.implode(',',$tmp);
			$writeConnect = $this->_getWriteConnect();
			
			$res = $writeConnect->query($edmertSql);
			
		}
		return true;	
	}
	public function importWhiteEmail($emails,$position=0) {
		$edmertSql = "INSERT INTO `edm_email_white`(`email`,`position`) VALUES ";
		$tmp = array();
		if (count($emails)) {
			foreach ($emails as $_email) {
				$tmpSql = "('".trim($_email)."','$position')";
				array_push($tmp,$tmpSql);
			}
			$edmertSql = $edmertSql.implode(',',$tmp);
			$writeConnect = $this->_getWriteConnect();
			
			$res = $writeConnect->query($edmertSql);
			
		}
		return true;	
	}
	public function importBannedEmail($emails,$position=0) {
		$edmertSql = "INSERT INTO `edm_banned_emails`(`emailaddress`,`list`,`bandate`) VALUES ";
		$tmp = array();
		$now = time();
		if (count($emails)) {
			foreach ($emails as $_email) {
				$tmpSql = "('".trim($_email)."','g','$now')";
				array_push($tmp,$tmpSql);
			}
			$edmertSql = $edmertSql.implode(',',$tmp);
			$writeConnect = $this->_getWriteConnect();		
			$res = $writeConnect->query($edmertSql);
			
		}
		return true;	
	}
	public function deleteValidateEmail($ids) {
		$deleteSql = "DELETE FROM `edm_email_validate` WHERE `validate_id` in ";
		if (count($ids)) {
			$deleteSql = $deleteSql."(".implode(',',$ids).")";
			$writeConnect = $this->_getWriteConnect();
			
			$res = $writeConnect->query($deleteSql);
		}
		return true;		
	}
}
