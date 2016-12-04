<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Post information tabs
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_View_Tabs extends Mage_Core_Block_Template
{
    protected $_tabs = array();

    /**
     * Add tab to the container
     *
     * @param string $title
     * @param string $block
     * @param string $template
     */
    function addTab($alias, $title, $block, $template)
    {

        if (!$title || !$block || !$template) {
            return false;
        }

        $this->_tabs[] = array(
            'alias' => $alias,
            'title' => $title
        );

        $this->setChild($alias,
            $this->getLayout()->createBlock($block, $alias)
                ->setTemplate($template)
            );
    }

    function getTabs()
    {
        return $this->_tabs;
    }
}
