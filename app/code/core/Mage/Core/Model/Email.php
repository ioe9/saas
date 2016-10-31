<?php
class Mage_Core_Model_Email extends Varien_Object
{
    protected $_tplVars = array();
    protected $_block;

    public function __construct()
    {
        // TODO: move to config
        $this->setFromName('Magento');
        $this->setFromEmail('magento@varien.com');
        $this->setType('text');
    }

    public function setTemplateVar($var, $value = null)
    {
        if (is_array($var)) {
            foreach ($var as $index=>$value) {
                $this->_tplVars[$index] = $value;
            }
        }
        else {
            $this->_tplVars[$var] = $value;
        }
        return $this;
    }

    public function getTemplateVars()
    {
        return $this->_tplVars;
    }

    public function getBody()
    {
        $body = $this->getData('body');
        if (empty($body) && $this->getTemplate()) {
            $this->_block = Mage::getModel('core/layout')->createBlock('core/template', 'email')
                ->setArea('frontend')
                ->setTemplate($this->getTemplate());
            foreach ($this->getTemplateVars() as $var=>$value) {
                $this->_block->assign($var, $value);
            }
            $this->_block->assign('_type', strtolower($this->getType()))
                ->assign('_section', 'body');
            $body = $this->_block->toHtml();
        }
        return $body;
    }

    public function getSubject()
    {
        $subject = $this->getData('subject');
        if (empty($subject) && $this->_block) {
            $this->_block->assign('_section', 'subject');
            $subject = $this->_block->toHtml();
        }
        return $subject;
    }

    public function send()
    {

        $mail = new Varien_Mail();

        if (strtolower($this->getType()) == 'html') {
            $mail->setBodyHtml($this->getBody());
        }
        else {
            $mail->setBodyText($this->getBody());
        }
		
        $mail->setFrom($this->getFromEmail(), $this->getFromName())
            ->addTo($this->getToEmail(), $this->getToName())
            ->setSubject($this->getSubject());
        if ($this->getCc()) {
        	$mail->addCc($this->getCc());
        }   
        $mail->send();

        return $this;
    }
}
