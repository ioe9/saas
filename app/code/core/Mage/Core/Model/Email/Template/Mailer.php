<?php
/**
 * Email Template Mailer Model
 *
 * @method Mage_Core_Model_Email_Template_Mailer setQueue(Mage_Core_Model_Abstract $value)
 * @method Mage_Core_Model_Email_Queue getQueue()
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Email_Template_Mailer extends Varien_Object
{
    /**
     * List of email infos
     * @see Mage_Core_Model_Email_Info
     *
     * @var array
     */
    protected $_emailInfos = array();

    /**
     * Add new email info to corresponding list
     *
     * @param Mage_Core_Model_Email_Info $emailInfo
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function addEmailInfo(Mage_Core_Model_Email_Info $emailInfo)
    {
        array_push($this->_emailInfos, $emailInfo);
        return $this;
    }

    /**
     * Send all emails from email list
     * @see self::$_emailInfos
     *
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function send()
    {
        /** @var $emailTemplate Mage_Core_Model_Email_Template */
        $emailTemplate = Mage::getModel('core/email_template');
        // Send all emails from corresponding list
        while (!empty($this->_emailInfos)) {
            $emailInfo = array_pop($this->_emailInfos);
            // Handle "Bcc" recipients of the current email
            $emailTemplate->addBcc($emailInfo->getBccEmails());
            // Set required design parameters and delegate email sending to Mage_Core_Model_Email_Template
            $emailTemplate->setDesignConfig(array('area' => 'frontend'))
                ->setQueue($this->getQueue())
                ->sendTransactional(
                    $this->getTemplateId(),
                    $this->getSender(),
                    $emailInfo->getToEmails(),
                    $emailInfo->getToNames(),
                    $this->getTemplateParams()
            );
        }
        return $this;
    }

    /**
     * Set email sender
     *
     * @param string|array $sender
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function setSender($sender)
    {
        return $this->setData('sender', $sender);
    }

    /**
     * Get email sender
     *
     * @return string|array|null
     */
    public function getSender()
    {
        return $this->_getData('sender');
    }


    /**
     * Set template id
     *
     * @param int $templateId
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function setTemplateId($templateId)
    {
        return $this->setData('template_id', $templateId);
    }

    /**
     * Get template id
     *
     * @return int|null
     */
    public function getTemplateId()
    {
        return $this->_getData('template_id');
    }

    /**
     * Set tempate parameters
     *
     * @param array $templateParams
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function setTemplateParams(array $templateParams)
    {
        return $this->setData('template_params', $templateParams);
    }

    /**
     * Get template parameters
     *
     * @return array|null
     */
    public function getTemplateParams()
    {
        return $this->_getData('template_params');
    }
}
