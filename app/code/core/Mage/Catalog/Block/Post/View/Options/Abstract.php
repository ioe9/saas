<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Post options abstract type block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
abstract class Mage_Catalog_Block_Post_View_Options_Abstract extends Mage_Core_Block_Template
{
    /**
     * Post object
     *
     * @var Mage_Catalog_Model_Post
     */
    protected $_post;

    /**
     * Post option object
     *
     * @var Mage_Catalog_Model_Post_Option
     */
    protected $_option;

    /**
     * Set Post object
     *
     * @param Mage_Catalog_Model_Post $post
     * @return Mage_Catalog_Block_Post_View_Options_Abstract
     */
    public function setPost(Mage_Catalog_Model_Post $post = null)
    {
        $this->_post = $post;
        return $this;
    }

    /**
     * Retrieve Post object
     *
     * @return Mage_Catalog_Model_Post
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     * Set option
     *
     * @param Mage_Catalog_Model_Post_Option $option
     * @return Mage_Catalog_Block_Post_View_Options_Abstract
     */
    public function setOption(Mage_Catalog_Model_Post_Option $option)
    {
        $this->_option = $option;
        return $this;
    }

    /**
     * Get option
     *
     * @return Mage_Catalog_Model_Post_Option
     */
    public function getOption()
    {
        return $this->_option;
    }

    public function getFormatedPrice()
    {
        if ($option = $this->getOption()) {
            return $this->_formatPrice(array(
                'is_percent'    => ($option->getPriceType() == 'percent'),
                'pricing_value' => $option->getPrice($option->getPriceType() == 'percent')
            ));
        }
        return '';
    }

    /**
     * Return formated price
     *
     * @param array $value
     * @return string
     */
    protected function _formatPrice($value, $flag=true)
    {
        if ($value['pricing_value'] == 0) {
            return '';
        }


        $sign = '+';
        if ($value['pricing_value'] < 0) {
            $sign = '-';
            $value['pricing_value'] = 0 - $value['pricing_value'];
        }

        $priceStr = $sign;


        if ($flag) {
            $priceStr = '<span class="price-notice">'.$priceStr.'</span>';
        }

        return $priceStr;
    }

    /**
     * Get price with including/excluding tax
     *
     * @param decimal $price
     * @param bool $includingTax
     * @return decimal
     */
    public function getPrice($price)
    {
        
        return $price;
    }

    /**
     * Returns price converted to current currency rate
     *
     * @param float $price
     * @return float
     */
    public function getCurrencyPrice($price)
    {

        return $price;
    }
}
