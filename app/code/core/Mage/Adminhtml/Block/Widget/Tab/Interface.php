<?php
/**
 * Adminhtml Widget Tab Interface
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
interface Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel();

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle();

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab();

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden();
}
