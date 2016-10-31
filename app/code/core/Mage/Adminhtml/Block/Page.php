<?php
class Mage_Adminhtml_Block_Page extends Mage_Adminhtml_Block_Template
{

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('page.phtml');
        $action = Mage::app()->getFrontController()->getAction();
        if ($action) {
            $this->addBodyClass($action->getFullActionName('-'));
        }
    }

    /**
     * Get current language
     *
     * @return unknown
     */
    public function getLang()
    {
        if (!$this->hasData('lang')) {
            $this->setData('lang', 'zh');
        }
        return $this->getData('lang');
    }

    /**
     * Add CSS class to page body tag
     *
     * @param string $className
     * @return Mage_Adminhtml_Block_Page
     */
    public function addBodyClass($className)
    {
        $className = preg_replace('#[^a-z0-9]+#', '-', strtolower($className));
        $this->setBodyClass($this->getBodyClass() . ' ' . $className);
        return $this;
    }

}
