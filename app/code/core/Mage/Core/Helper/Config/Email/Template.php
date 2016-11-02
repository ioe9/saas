<?php
/****
 * 
 */
class Mage_Core_Helper_Config_Email_Template extends Mage_Core_Helper_Abstract
{
	public function getDefaultTemplates() {
		return array(
			'admin_emails_forgot_email_template' => 
				array(
					'@' => array(
						'translate' => 'label',
						'module'=>'adminhtml'
						),
					'label' => '忘记密码',
					'file' => 'admin_password_reset_confirmation.html',
					'type' => 'html',
				)
			
		);
	}
}