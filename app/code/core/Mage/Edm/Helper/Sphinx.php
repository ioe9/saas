<?php
class Mage_Edm_Helper_Sphinx extends Mage_Core_Helper_Abstract
{
	protected $_host = 'localhost';
	protected $_port = '9312';
	protected $_client;
    
    public function __construct() {
    	if (!$this->_client) {
    		$this->_client = $this->initClient();
    	}
   		return $this;
    }
    public function getClient() {
    	return $this->_client;
    }
	public function initClient() {
		try {
			$cl = new SphinxClient();
			$cl->SetServer($this->_host, $this->_port);
			$cl->SetMaxQueryTime(2000);
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
		return $cl;
		
	}
	
	public function setMatchMode($mode) {
		
		$modeArr = array(
		   SPH_MATCH_ALL,
		   SPH_MATCH_ANY,
		   SPH_MATCH_PHRASE,
		   SPH_MATCH_BOOLEAN,
		   SPH_MATCH_EXTENDED,
		   SPH_MATCH_EXTENDED2,
			
		);
		if (in_array($mode,$modeArr)) {
			$this->_client->SetMatchMode($mode);
		}
		return $this;
	}
	public function setFilter($attribute, $values, $exclude=false) {
		$this->_client->ResetFilters();
		$this->_client->SetFilter($attribute, $values, $exclude);
		return $this;
	}
	public function query($query,$index) {
		//$this->_client->SetLimits(0, 10000);
		$res = $this->_client->Query($query,$index);
		
		return $res;
	}
}
?>