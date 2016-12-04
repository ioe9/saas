<?php
/**
 * Zend html block
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Template_Zend extends Mage_Core_Block_Template
{

    protected $_view = null;

    /**
     * Class constructor. Base html block
     *
     * @param      none
     * @return     void
     */
    function _construct()
    {
        parent::_construct();
        $this->_view = new Zend_View();
    }

    public function assign($key, $value=null)
    {
        if (is_array($key) && is_null($value)) {
            foreach ($key as $k=>$v) {
                $this->assign($k, $v);
            }
        } elseif (!is_null($value)) {
            $this->_view->assign($key, $value);
        }
        return $this;
    }

    public function setScriptPath($dir)
    {
        $this->_view->setScriptPath($dir.DS);
    }

    public function fetchView($fileName)
    {
        return $this->_view->render($fileName);
    }

}
