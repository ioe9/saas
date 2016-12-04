<?php
/**
 * Immediate flush block. To be used only as root
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Flush extends Mage_Core_Block_Abstract
{

    protected function _toHtml()
    {
        if (!$this->_beforeToHtml()) {
            return '';
        }

        ob_implicit_flush();

        foreach ($this->getSortedChildren() as $name) {
            $block = $this->getLayout()->getBlock($name);
            if (!$block) {
                Mage::exception(Mage::helper('core')->__('Invalid block: %s', $name));
            }
            echo $block->toHtml();
        }
    }

}
