<?php
/**
 * Top menu block item renderer
 *
 * @category    Mage
 * @package     Mage_Page
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Page_Block_Html_Topmenu_Renderer extends Mage_Page_Block_Html_Topmenu
{
    protected $_templateFile;

    /**
     * Renders block html
     * @return string
     * @throws Exception
     */
    protected function _toHtml()
    {
        $this->_addCacheTags();
        $menuTree = $this->getMenuTree();
        $childrenWrapClass = $this->getChildrenWrapClass();
        if (!$this->getTemplate() || is_null($menuTree) || is_null($childrenWrapClass)) {
            throw new Exception("Top-menu renderer isn't fully configured.");
        }

        $includeFilePath = realpath(Mage::getBaseDir('design') . DS . $this->getTemplateFile());
        if (strpos($includeFilePath, realpath(Mage::getBaseDir('design'))) === 0 || $this->_getAllowSymlinks()) {
            $this->_templateFile = $includeFilePath;
        } else {
            throw new Exception('Not valid template file:' . $this->_templateFile);
        }
        return $this->render($menuTree, $childrenWrapClass);
    }

    /**
     * Add cache tags
     *
     * @return void
     */
    protected function _addCacheTags()
    {
        $parentBlock = $this->getParentBlock();
        if ($parentBlock) {
            $this->addCacheTag($parentBlock->getCacheTags());
        }
    }

    /**
     * Fetches template. If template has return statement, than its value is used and direct output otherwise.
     * @param Varien_Data_Tree_Node $menuTree
     * @param $childrenWrapClass
     * @return string
     */
    public function render(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        ob_start();
        $html = include $this->_templateFile;
        $directOutput = ob_get_clean();

        if (is_string($html)) {
            return $html;
        } else {
            return $directOutput;
        }
    }
}
