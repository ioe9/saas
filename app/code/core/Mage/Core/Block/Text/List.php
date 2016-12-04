<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Core_Block_Text_List extends Mage_Core_Block_Text
{
    protected function _toHtml()
    {
        $this->setText('');
        foreach ($this->getSortedChildren() as $name) {
            $block = $this->getLayout()->getBlock($name);
            if (!$block) {
                Mage::throwException(Mage::helper('core')->__('Invalid block: %s', $name));
            }
            $this->addText($block->toHtml());
        }
        return parent::_toHtml();
    }
}
