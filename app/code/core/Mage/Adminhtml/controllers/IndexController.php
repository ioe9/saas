<?php
class Mage_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Render specified template
     *
     * @param string $tplName
     * @param array $data parameters required by template
     */
    protected function _outTemplate($tplName, $data = array())
    {
        $this->_initLayoutMessages('adminhtml/session');
        $block = $this->getLayout()->createBlock('adminhtml/template')->setTemplate("$tplName.phtml");
        foreach ($data as $index => $value) {
            $block->assign($index, $value);
        }
        $html = $block->toHtml();
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        $this->getResponse()->setBody($html);
    }

    /**
     * Admin area entry point
     * Always redirects to the startup page url
     */
    public function indexAction()
    {
    	
        $session = Mage::getSingleton('admin/session');
        $url = $session->getUser()->getStartupPageUrl();
        if ($session->isFirstPageAfterLogin()) {
            $session->setIsFirstPageAfterLogin(true);
        }
        $this->_redirect('adminhtml/dashboard');
    }

    /***
     * 允许注册使用
     */
    public function registerAction() {
    	if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $this->_redirect('*');
            return;
        }
        
        $registerData = $this->getRequest()->getParam('register');
        $varienObject = new Varien_Object();
        if ($registerData && array_key_exists('email',$registerData)) {
        	$varienObject->addData($registerData);
        	Mage::getSingleton('adminhtml/session')->setRegisterFormData($varienObject);
        }
        
        $affCodeValid = false;
        if ($registerData) {
        	$affCode = $registerData['aff_code'];
	        if (!$affCode) {
	        	Mage::getSingleton('adminhtml/session')->addError("请填写有效的邀请码");
	        	$this->_redirect('adminhtml/index/register');
	            return;
	        }
	        $aff = Mage::getResourceModel('ins/aff_collection')
					->addFieldToFilter('aff_code',$affCode)
					->getFirstItem();
			if ($aff->getId() && $aff->getData('status')) {
				$countLimit = $aff->getData('count_limit');
				$countUsed = $aff->getData('count_used');
				if ($countLimit==0 ||$countUsed<$countLimit) {
					$affCodeValid = $affCode;
				} else {
					Mage::getSingleton('adminhtml/session')->addError("邀请码已经超过最大限制试用次数");
		        	$this->_redirect('adminhtml/index/register');
		            return;
				}
			} else {
				Mage::getSingleton('adminhtml/session')->addError("邀请码无效，请再次确认后重试");
	        	$this->_redirect('adminhtml/index/register');
	            return;
			}
        }
	        
			
        
        if ($affCodeValid && $registerData) {
        	$email   = isset($registerData['email']) ? $registerData['email'] : '';
	        $username   = isset($registerData['username']) ? $registerData['username'] : '';
	        $password   = isset($registerData['password']) ? $registerData['password'] : '';
	        
	        if ($email && $username && $password) {
	        	$model = Mage::getModel('admin/user');
	        	$model->setData($registerData);
	        	$result = $model->validate();
	        	
	        	if (is_array($result)) {
	                Mage::getSingleton('adminhtml/session')->setUserData($registerData);
	                foreach ($result as $message) {
	                    Mage::getSingleton('adminhtml/session')->addError($message);
	                }
	                $this->_redirect('*/*/register');
	                return $this;
	            }
	
	            try {
	            	
	            	//echo "<xmp>";var_dump($registerData);var_dump($model->getData());echo "</xmp>";die();
	            	$model->setData('aff_code',$affCodeValid);
	                $model->save();
	                $aff->setData('count_used',$aff->getData('count_used')+1)->save();
	                
	                $company = Mage::getModel('admin/company');
	                //$company->addData($sampleCompanyData);
	                $company->setData('user_id',$model->getId())
	                	->setData('contact_email',$email)
	                	->save();
                	//Mage::helper('ins/front_company')->addSampleData($company);
                	//设置sample分类
					                	
                	//创建默认模版,放到helper里
					Mage::helper('ins/company_init')->initCompany($company);
						
					
                	$model->load($model->getId());
                	$model->setData('company_id',$company->getId())->save();
	                $uRoles = array("1");//
	                    
                    $model->setRoleIds($uRoles)
                        ->setRoleUserId($model->getUserId())
                        ->saveRelations();
	                $session = Mage::getSingleton('admin/session');
	                $session->login($username, $password);
					Mage::getSingleton('adminhtml/session')->setRegisterFormData(false);
	                //
	                Mage::getSingleton('adminhtml/session')->addSuccess("恭喜您！帐号注册成功，<a href='".$this->getUrl('adminhtml/index')."'>立即体验&gt;&gt;</a>");
	            } catch (Exception $e) {
	            	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	            	Mage::getSingleton('adminhtml/session')->addError("注册失败，请联系管理员");
	            }
	        } else {
	        	Mage::getSingleton('adminhtml/session')->addError("无效请求，请重试");
	        }
        }
	        
        
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Administrator login action
     */
    public function loginAction()
    {

	                
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            //$this->_redirect('adminhtml/email/new');
            return;
        }
        
        $loginData = $this->getRequest()->getParam('login');
        $username = (is_array($loginData) && array_key_exists('username', $loginData)) ? $loginData['username'] : null;
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Administrator logout action
     */
    public function logoutAction()
    {
        /** @var $adminSession Mage_Admin_Model_Session */
        $adminSession = Mage::getSingleton('admin/session');
        $adminSession->unsetAll();
        $adminSession->getCookie()->delete($adminSession->getSessionName());
        $adminSession->addSuccess(Mage::helper('adminhtml')->__('You have logged out.'));

        $this->_redirect('*');
    }


    /**
     * Test action
     */
    public function testAction()
    {
        echo $this->getLayout()->createBlock('core/profiler')->toHtml();
    }

    /**
     * Denied JSON action
     */
    public function deniedJsonAction()
    {
        $this->getResponse()->setBody($this->_getDeniedJson());
    }

    /**
     * Retrieve response for deniedJsonAction()
     */
    protected function _getDeniedJson()
    {
        return Mage::helper('core')->jsonEncode(array(
            'ajaxExpired' => 1,
            'ajaxRedirect' => $this->getUrl('*/index/login')
        ));
    }

    /**
     * Denied IFrame action
     */
    public function deniedIframeAction()
    {
        $this->getResponse()->setBody($this->_getDeniedIframe());
    }

    /**
     * Retrieve response for deniedIframeAction()
     */
    protected function _getDeniedIframe()
    {
        return '<script type="text/javascript">parent.window.location = \''
            . $this->getUrl('*/index/login') . '\';</script>';
    }

    /**
     * Forgot administrator password action
     */
    public function forgotpasswordAction()
    {
        $email = (string) $this->getRequest()->getParam('email');
        $params = $this->getRequest()->getParams();

        if (!empty($email) && !empty($params)) {
            // Validate received data to be an email address
            if (Zend_Validate::is($email, 'EmailAddress')) {
                $collection = Mage::getResourceModel('admin/user_collection');
                /** @var $collection Mage_Admin_Model_Resource_User_Collection */
                $collection->addFieldToFilter('email', $email);
                $collection->load(false);

                if ($collection->getSize() > 0) {
                    foreach ($collection as $item) {
                        $user = Mage::getModel('admin/user')->load($item->getId());
                        if ($user->getId()) {
                            $newResetPasswordLinkToken = Mage::helper('admin')->generateResetPasswordLinkToken();
                            $user->changeResetPasswordLinkToken($newResetPasswordLinkToken);
                            $user->save();
                            $user->sendPasswordResetConfirmationEmail();
                        }
                        break;
                    }
                }
                $this->_getSession()
                    ->addSuccess(Mage::helper('adminhtml')->__('If there is an account associated with %s you will receive an email with a link to reset your password.', Mage::helper('adminhtml')->escapeHtml($email)));
                $this->_redirect('*/*/login');
                return;
            } else {
                $this->_getSession()->addError($this->__('Invalid email address.'));
            }
        } elseif (!empty($params)) {
            $this->_getSession()->addError(Mage::helper('adminhtml')->__('The email address is empty.'));
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Display reset forgotten password form
     *
     * User is redirected on this action when he clicks on the corresponding link in password reset confirmation email
     */
    public function resetPasswordAction()
    {
        $resetPasswordLinkToken = (string) $this->getRequest()->getQuery('token');
        $userId = (int) $this->getRequest()->getQuery('id');
        try {
            $this->_validateResetPasswordLinkToken($userId, $resetPasswordLinkToken);
            $data = array(
                'userId' => $userId,
                'resetPasswordLinkToken' => $resetPasswordLinkToken
            );
            $this->_outTemplate('resetforgottenpassword', $data);
        } catch (Exception $exception) {
            $this->_getSession()->addError(Mage::helper('adminhtml')->__('Your password reset link has expired.'));
            $this->_redirect('*/*/forgotpassword', array('_nosecret' => true));
        }
    }

    /**
     * Reset forgotten password
     *
     * Used to handle data recieved from reset forgotten password form
     */
    public function resetPasswordPostAction()
    {
        $resetPasswordLinkToken = (string) $this->getRequest()->getQuery('token');
        $userId = (int) $this->getRequest()->getQuery('id');
        $password = (string) $this->getRequest()->getPost('password');
        $passwordConfirmation = (string) $this->getRequest()->getPost('confirmation');

        try {
            $this->_validateResetPasswordLinkToken($userId, $resetPasswordLinkToken);
        } catch (Exception $exception) {
            $this->_getSession()->addError(Mage::helper('adminhtml')->__('Your password reset link has expired.'));
            $this->_redirect('*/*/');
            return;
        }

        $errorMessages = array();
        if (iconv_strlen($password) <= 0) {
            array_push($errorMessages, Mage::helper('adminhtml')->__('New password field cannot be empty.'));
        }
        /** @var $user Mage_Admin_Model_User */
        $user = $this->_getModel('admin/user')->load($userId);

        $user->setNewPassword($password);
        $user->setPasswordConfirmation($passwordConfirmation);
        $validationErrorMessages = $user->validate();
        if (is_array($validationErrorMessages)) {
            $errorMessages = array_merge($errorMessages, $validationErrorMessages);
        }

        if (!empty($errorMessages)) {
            foreach ($errorMessages as $errorMessage) {
                $this->_getSession()->addError($errorMessage);
            }
            $data = array(
                'userId' => $userId,
                'resetPasswordLinkToken' => $resetPasswordLinkToken
            );
            $this->_outTemplate('resetforgottenpassword', $data);
            return;
        }

        try {
            // Empty current reset password token i.e. invalidate it
            $user->setRpToken(null);
            $user->setRpTokenCreatedAt(null);
            $user->save();
            $this->_getSession()->addSuccess(Mage::helper('adminhtml')->__('Your password has been updated.'));
            $this->_redirect('*/*/login');
        } catch (Exception $exception) {
            $this->_getSession()->addError($exception->getMessage());
            $data = array(
                'userId' => $userId,
                'resetPasswordLinkToken' => $resetPasswordLinkToken
            );
            $this->_outTemplate('resetforgottenpassword', $data);
            return;
        }
    }

    /**
     * Check if password reset token is valid
     *
     * @param int $userId
     * @param string $resetPasswordLinkToken
     * @throws Mage_Core_Exception
     */
    protected function _validateResetPasswordLinkToken($userId, $resetPasswordLinkToken)
    {
        if (!is_int($userId)
            || !is_string($resetPasswordLinkToken)
            || empty($resetPasswordLinkToken)
            || empty($userId)
            || $userId < 0
        ) {
            throw Mage::exception('Mage_Core', Mage::helper('adminhtml')->__('Invalid password reset token.'));
        }

        /** @var $user Mage_Admin_Model_User */
        $user = Mage::getModel('admin/user')->load($userId);
        if (!$user || !$user->getId()) {
            throw Mage::exception('Mage_Core', Mage::helper('adminhtml')->__('Wrong account specified.'));
        }

        $userToken = $user->getRpToken();
        if (strcmp($userToken, $resetPasswordLinkToken) != 0 || $user->isResetPasswordLinkTokenExpired()) {
            throw Mage::exception('Mage_Core', Mage::helper('adminhtml')->__('Your password reset link has expired.'));
        }
    }

    /**
     * Check if user has permissions to access this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Retrieve model object
     *
     * @link    Mage_Core_Model_Config::getModelInstance
     * @param   string $modelClass
     * @param   array|object $arguments
     * @return  Mage_Core_Model_Abstract|false
     */
    protected function _getModel($modelClass = '', $arguments = array())
    {
        return Mage::getModel($modelClass, $arguments);
    }
}
