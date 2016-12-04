<?php
/**
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Mage_Core_Model_Layout_Element extends Varien_Simplexml_Element
{
    public function prepare($args)
    {
        switch ($this->getName()) {
            case 'layoutUpdate':
                break;

            case 'layout':
                break;

            case 'update':
                break;

            case 'remove':
                break;

            case 'block':
                $this->prepareBlock($args);
                break;

            case 'reference':
                $this->prepareReference($args);
                break;

            case 'action':
                $this->prepareAction($args);
                break;

            default:
                $this->prepareActionArgument($args);
                break;
        }
        $children = $this->children();
        foreach ($this as $child) {
            $child->prepare($args);
        }
        return $this;
    }

    public function getBlockName()
    {
        $tagName = (string)$this->getName();
        if ('block'!==$tagName && 'reference'!==$tagName || empty($this['name'])) {
            return false;
        }
        return (string)$this['name'];
    }

    public function prepareBlock($args)
    {
        $type = (string)$this['type'];
        $name = (string)$this['name'];

        $className = (string)$this['class'];
        if (!$className) {
            $className = Mage::getConfig()->getBlockClassName($type);
            $this->addAttribute('class', $className);
        }

        $parent = $this->getParent();
        if (isset($parent['name']) && !isset($this['parent'])) {
            $this->addAttribute('parent', (string)$parent['name']);
        }

        return $this;
    }

    public function prepareReference($args)
    {
        return $this;
    }

    public function prepareAction($args)
    {
        $parent = $this->getParent();
        $this->addAttribute('block', (string)$parent['name']);

        return $this;
    }

    public function prepareActionArgument($args)
    {
        return $this;
    }

}
