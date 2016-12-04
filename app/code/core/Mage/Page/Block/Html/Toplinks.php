<?php
/**
 * @deprecated after 1.4.0.1
 */
class Mage_Page_Block_Html_Toplinks extends Mage_Core_Block_Template
{
    /**
     * Array of toplinks
     *
     * array(
     *  [$index] => array(
     *                  ['liParams']
     *                  ['aParams']
     *                  ['innerText']
     *                  ['beforeText']
     *                  ['afterText']
     *                  ['first']
     *                  ['last']
     *              )
     * )
     *
     * @var array
     */
    protected $_toplinks = array();

    function __construct()
    {
        parent::__construct();
        $this->setTemplate('page/html/top.links.phtml');
    }

    /**
     * Add link
     *
     * @param string|array $liParams
     * @param string|array $aParams
     * @param string $innerText
     * @param int $position
     * @param string $beforeText
     * @param string $afterText
     * @return Mage_Page_Block_Html_Toplinks
     */
    public function addLink($liParams, $aParams, $innerText, $position='', $beforeText='', $afterText='')
    {
        $params = '';
        if (!empty($liParams) && is_array($liParams)) {
            foreach ($liParams as $key=>$value) {
                $params .= ' ' . $key . '="' . addslashes($value) . '"';
            }
        } elseif (is_string($liParams)) {
            $params .= ' ' . $liParams;
        }
        $toplinkInfo['liParams'] = $params;
        $params = '';
        if (!empty($aParams) && is_array($aParams)) {
            foreach ($aParams as $key=>$value) {
                $params .= ' ' . $key . '="' . addslashes($value) . '"';
            }
        } elseif (is_string($aParams)) {
            $params .= ' ' . $aParams;
        }
        $toplinkInfo['aParams'] = $params;
        $toplinkInfo['innerText'] = $innerText;
        $toplinkInfo['beforeText'] = $beforeText;
        $toplinkInfo['afterText'] = $afterText;
        $this->_prepareArray($toplinkInfo, array('liParams', 'aParams', 'innerText', 'beforeText', 'afterText', 'first', 'last'));
        if (is_numeric($position)) {
            array_splice($this->_toplinks, $position, 0, array($toplinkInfo));
        } else {
            $this->_toplinks[] = $toplinkInfo;
        }
        return $this;
    }

    protected function _toHtml()
    {
        if (is_array($this->_toplinks) && $this->_toplinks) {
            reset($this->_toplinks);
            $this->_toplinks[key($this->_toplinks)]['first'] = true;
            end($this->_toplinks);
            $this->_toplinks[key($this->_toplinks)]['last'] = true;
        }
        $this->assign('toplinks', $this->_toplinks);
        return parent::_toHtml();
    }
}
