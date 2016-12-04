<?php
/**
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2016 Jongjian Ltd.Co.
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml queue grid block.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Newsletter_Queue extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('newsletter/queue/list.phtml');
    }

    protected function _beforeToHtml()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('adminhtml/newsletter_queue_grid', 'newsletter.queue.grid'));
        return parent::_beforeToHtml();
    }

}
