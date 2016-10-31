<?php
class Mage_Admin_Model_Observer
{
    const FLAG_NO_LOGIN = 'no-login';
    /**
     * Handler for controller_action_predispatch event
     *
     * @param Varien_Event_Observer $observer
     * @return boolean
     */
    public function actionPreDispatchAdmin($observer)
    {
    	
        $session = Mage::getSingleton('admin/session');
        /** @var $session Mage_Admin_Model_Session */

        /**
         * @var $request Mage_Core_Controller_Request_Http
         */
        $request = Mage::app()->getRequest();
        $user = $session->getUser();

        $requestedActionName = $request->getActionName();
        $openActions = array(
            'forgotpassword',
            'resetpassword',
            'resetpasswordpost',
            'logout',
            'refresh' // captcha refresh
        );
        if (in_array($requestedActionName, $openActions)) {
            $request->setDispatched(true);
        } else {
            if ($user) {
                $user->reload();
            }
            if (!$user || !$user->getId()) {
            	
                if ($request->getPost('login')) {
                    $postLogin  = $request->getPost('login');
                    $username   = isset($postLogin['username']) ? $postLogin['username'] : '';
                    $password   = isset($postLogin['password']) ? $postLogin['password'] : '';
                    $session->login($username, $password, $request);
                    
                    
                    $request->setPost('login', null);
                }
                if (!$request->getInternallyForwarded()) {
                	
                    $request->setInternallyForwarded();
                    if ($request->getParam('isIframe')) {
                        $request->setParam('forwarded', true)
                            ->setControllerName('index')
                            ->setActionName('deniedIframe')
                            ->setDispatched(false);
                    } elseif ($request->getParam('isAjax')) {
                        $request->setParam('forwarded', true)
                            ->setControllerName('index')
                            ->setActionName('deniedJson')
                            ->setDispatched(false);
                    } else {
                        $request->setParam('forwarded', true)
                            ->setRouteName('adminhtml')
                            ->setControllerName('index')
                            ->setActionName('login')
                            ->setDispatched(false);
                    }
                    return false;
                }
            }
        }

        $session->refreshAcl();
    }

    /**
     * Unset session first visit flag after displaying page
     *
     * @deprecated after 1.4.0.1, logic moved to admin session
     * @param Varien_Event_Observer $event
     */
    public function actionPostDispatchAdmin($event)
    {
    }
}
