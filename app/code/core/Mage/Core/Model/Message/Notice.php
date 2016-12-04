<?php
/**

 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Mage_Core_Model_Message_Notice extends Mage_Core_Model_Message_Abstract
{
    public function __construct($code)
    {
        parent::__construct(Mage_Core_Model_Message::NOTICE, $code);
    }
}
