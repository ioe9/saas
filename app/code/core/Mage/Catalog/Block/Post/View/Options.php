<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Post options block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_View_Options extends Mage_Core_Block_Template
{
    protected $_post;

    protected $_optionRenders = array();

    public function __construct()
    {
        parent::__construct();
        $this->addOptionRenderer(
            'default',
            'catalog/post_view_options_type_default',
            'catalog/post/view/options/type/default.phtml'
        );
    }

    /**
     * Retrieve post object
     *
     * @return Mage_Catalog_Model_Post
     */
    public function getPost()
    {
        if (!$this->_post) {
            if (Mage::registry('current_post')) {
                $this->_post = Mage::registry('current_post');
            } else {
                $this->_post = Mage::getSingleton('catalog/post');
            }
        }
        return $this->_post;
    }

    /**
     * Set post object
     *
     * @param Mage_Catalog_Model_Post $post
     * @return Mage_Catalog_Block_Post_View_Options
     */
    public function setPost(Mage_Catalog_Model_Post $post = null)
    {
        $this->_post = $post;
        return $this;
    }

    /**
     * Add option renderer to renderers array
     *
     * @param string $type
     * @param string $block
     * @param string $template
     * @return Mage_Catalog_Block_Post_View_Options
     */
    public function addOptionRenderer($type, $block, $template)
    {
        $this->_optionRenders[$type] = array(
            'block' => $block,
            'template' => $template,
            'renderer' => null
        );
        return $this;
    }

    /**
     * Get option render by given type
     *
     * @param string $type
     * @return array
     */
    public function getOptionRender($type)
    {
        if (isset($this->_optionRenders[$type])) {
            return $this->_optionRenders[$type];
        }

        return $this->_optionRenders['default'];
    }

    public function getGroupOfOption($type)
    {
        $group = Mage::getSingleton('catalog/post_option')->getGroupByType($type);

        return $group == '' ? 'default' : $group;
    }

    /**
     * Get post options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->getPost()->getOptions();
    }

    public function hasOptions()
    {
        if ($this->getOptions()) {
            return true;
        }
        return false;
    }

    /**
     * Get price configuration
     *
     * @param Mage_Catalog_Model_Post_Option_Value|Mage_Catalog_Model_Post_Option $option
     * @return array
     */
    protected function _getPriceConfiguration($option)
    {
        $data = array();
        $data['price']      = Mage::helper('core')->currency($option->getPrice(true), false, false);
        $data['oldPrice']   = Mage::helper('core')->currency($option->getPrice(false), false, false);
        $data['priceValue'] = $option->getPrice(false);
        $data['type']       = $option->getPriceType();
        
        return $data;
    }

    /**
     * Get json representation of
     *
     * @return string
     */
    public function getJsonConfig()
    {
        $config = array();

        foreach ($this->getOptions() as $option) {
            /* @var $option Mage_Catalog_Model_Post_Option */
            $priceValue = 0;
            if ($option->getGroupByType() == Mage_Catalog_Model_Post_Option::OPTION_GROUP_SELECT) {
                $_tmpPriceValues = array();
                foreach ($option->getValues() as $value) {
                    /* @var $value Mage_Catalog_Model_Post_Option_Value */
                    $id = $value->getId();
                    $_tmpPriceValues[$id] = $this->_getPriceConfiguration($value);
                }
                $priceValue = $_tmpPriceValues;
            } else {
                $priceValue = $this->_getPriceConfiguration($option);
            }
            $config[$option->getId()] = $priceValue;
        }

        return Mage::helper('core')->jsonEncode($config);
    }

    /**
     * Get option html block
     *
     * @param Mage_Catalog_Model_Post_Option $option
     */
    public function getOptionHtml(Mage_Catalog_Model_Post_Option $option)
    {
        $renderer = $this->getOptionRender(
            $this->getGroupOfOption($option->getType())
        );
        if (is_null($renderer['renderer'])) {
            $renderer['renderer'] = $this->getLayout()->createBlock($renderer['block'])
                ->setTemplate($renderer['template']);
        }
        return $renderer['renderer']
            ->setPost($this->getPost())
            ->setOption($option)
            ->toHtml();
    }
}
