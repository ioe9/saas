<?php
class Mage_Edm_Helper_Attr extends Mage_Core_Helper_Abstract
{
	public function getTypeOption() {
		return array(
			"text" => 'Text Field',
			"textarea" => 'Multiline Text Field',
			"number" => 'Numbers Only',
			'select' => 'Pick List',
			'multiselect' => 'Multiple Pick List',
			'checkbox' => 'Checkboxes',
			'radio' => 'Radio Buttons',
			'date' => 'Date Field',
		);
	}
}
