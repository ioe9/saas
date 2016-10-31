<?php
class Mage_Page_Helper_Layout extends Mage_Core_Helper_Abstract
{
    /**
     * Apply page layout handle
     *
     * @param string $pageLayout
     * @return Mage_Page_Helper_Layout
     */
    public function applyHandle($pageLayout)
    {
        $pageLayout = $this->_getConfig()->getPageLayout($pageLayout);

        if (!$pageLayout) {
            return $this;
        }

        $this->getLayout()
            ->getUpdate()
            ->addHandle($pageLayout->getLayoutHandle());

        return $this;
    }

    /**
     * Apply page layout template
     * (for old design packages)
     *
     * @param string $pageLayout
     * @return Mage_Page_Helper_Layout
     */
    public function applyTemplate($pageLayout = null)
    {
        if ($pageLayout === null) {
            $pageLayout = $this->getCurrentPageLayout();
        } else {
            $pageLayout = $this->_getConfig()->getPageLayout($pageLayout);
        }

        if (!$pageLayout) {
            return $this;
        }

        if ($this->getLayout()->getBlock('root') &&
            !$this->getLayout()->getBlock('root')->getIsHandle()) {
                // If not applied handle
                $this->getLayout()
                    ->getBlock('root')
                    ->setTemplate($pageLayout->getTemplate());
        }

        return $this;
    }

    /**
     * Retrieve current applied page layout
     *
     * @return Varien_Object|boolean
     */
    public function getCurrentPageLayout()
    {
        if ($this->getLayout()->getBlock('root') &&
            $this->getLayout()->getBlock('root')->getLayoutCode()) {
            return $this->_getConfig()->getPageLayout($this->getLayout()->getBlock('root')->getLayoutCode());
        }

        // All loaded handles
        $handles = $this->getLayout()->getUpdate()->getHandles();
        // Handles used in page layouts
        $pageLayoutHandles = $this->_getConfig()->getPageLayoutHandles();
        // Applied page layout handles
        $appliedHandles = array_intersect($handles, $pageLayoutHandles);

        if (empty($appliedHandles)) {
            return false;
        }

        $currentHandle = array_pop($appliedHandles);

        $layoutCode = array_search($currentHandle, $pageLayoutHandles, true);

        return $this->_getConfig()->getPageLayout($layoutCode);
    }

    /**
     * Retrieve page config
     *
     * @return Mage_Page_Model_Config
     */
    protected function _getConfig()
    {
        return Mage::getSingleton('page/config');
    }
    
    public function getDefaultLayouts()
    {
    	return array(
    		'empty' => array(
    			'label' => 'Empty',
    			'template' => 'page/empty.phtml',
    			'layout_handle' => 'page_empty',
    			'is_default' => 0,
    		),
    		
    		'one_column' => array(
    			'label' => '1 column',
    			'template' => 'page/1column.phtml',
    			'layout_handle' => 'page_one_column',
    			'is_default' => 1,
    		),
    		
    		'two_columns_left' => array(
    			'label' => '2 columns with left bar',
    			'template' => 'page/2columns-left.phtml',
    			'layout_handle' => 'page_two_columns_left',
    			'is_default' => 0,
    		),
    		
    		'two_columns_right' => array(
    			'label' => '2 columns with right bar',
    			'template' => 'page/2columns-right.phtml',
    			'layout_handle' => 'page_two_columns_right',
    			'is_default' => 0,
    		),
    		
    		'three_columns' => array(
    			'label' => '3 columns',
    			'template' => 'page/3columns.phtml',
    			'layout_handle' => 'page_three_columns',
    			'is_default' => 0,
    		),
    	
    	);
    }
}
