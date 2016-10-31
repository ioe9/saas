<?php
class Mage_Page_Block_Html_Header extends Mage_Core_Block_Template
{
    public function _construct()
    {
        $this->setTemplate('page/html/header.phtml');
    }

    /**
     * Check if current url is url for home page
     *
     * @return true
     */
    public function getIsHomePage()
    {
        return $this->getUrl('') == $this->getUrl('*/*/*', array('_current'=>true, '_use_rewrite'=>true));
    }

    public function setLogo($logo_src, $logo_alt)
    {
        $this->setLogoSrc($logo_src);
        $this->setLogoAlt($logo_alt);
        return $this;
    }

    public function getLogoSrc()
    {
        if (empty($this->_data['logo_src'])) {
            $this->_data['logo_src'] = Mage::getStoreConfig('design/header/logo_src');
        }
        return $this->getSkinUrl($this->_data['logo_src']);
    }

    public function getLogoSrcSmall()
    {
        if (empty($this->_data['logo_src_small'])) {
            $this->_data['logo_src_small'] = Mage::getStoreConfig('design/header/logo_src_small');
        }
        return $this->getSkinUrl($this->_data['logo_src_small']);
    }

    public function getLogoAlt()
    {
        if (empty($this->_data['logo_alt'])) {
            $this->_data['logo_alt'] = Mage::getStoreConfig('design/header/logo_alt');
        }
        return $this->_data['logo_alt'];
    }

    /**
     * Retrieve page welcome message
     *
     * @deprecated after 1.7.0.2
     * @see Mage_Page_Block_Html_Welcome
     * @return mixed
     */
    public function getWelcome()
    {
        if (empty($this->_data['welcome'])) {
            if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
                $this->_data['welcome'] = $this->__('Welcome, %s!', $this->escapeHtml(Mage::getSingleton('customer/session')->getCustomer()->getName()));
            } else {
                $this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
            }
        }

        return $this->_data['welcome'];
    }
}
