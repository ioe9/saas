<?php
class Mage_Adminhtml_Block_Page_Menu extends Mage_Adminhtml_Block_Template
{
    const CACHE_TAGS = 'BACKEND_MAINMENU';

    /**
     * Adminhtml URL instance
     *
     * @var Mage_Adminhtml_Model_Url
     */
    protected $_url;

    /**
     * Initialize template and cache settings
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('page/menu.phtml');
        $this->_url = Mage::getModel('adminhtml/url');
        $this->setCacheTags(array(self::CACHE_TAGS));
    }

    /**
     * Retrieve cache lifetime
     *
     * @return int
     */
    public function getCacheLifetime()
    {
        return 86400;
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $cacheKeyInfo = array(
            'admin_top_nav',
            $this->getActive(),
            Mage::getSingleton('admin/session')->getUser()->getId(),
        );
        // Add additional key parameters if needed
        $additionalCacheKeyInfo = $this->getAdditionalCacheKeyInfo();
        if (is_array($additionalCacheKeyInfo) && !empty($additionalCacheKeyInfo)) {
            $cacheKeyInfo = array_merge($cacheKeyInfo, $additionalCacheKeyInfo);
        }
        return $cacheKeyInfo;
    }

    /**
     * Retrieve Adminhtml Menu array
     *
     * @return array
     */
    public function getMenuArray()
    {
        return $this->_buildMenuArray();
    }

    /**
     * Retrieve Title value for menu node
     *
     * @param Varien_Simplexml_Element $child
     * @return string
     */
    protected function _getHelperValue(Varien_Simplexml_Element $child)
    {
        $helperName         = 'adminhtml';
        $titleNodeName      = 'title';
        $childAttributes    = $child->attributes();
        if (isset($childAttributes['module'])) {
            $helperName     = (string)$childAttributes['module'];
        }
//        if (isset($childAttributes['translate'])) {
//            $titleNodeName  = (string)$childAttributes['translate'];
//        }

        return Mage::helper($helperName)->__((string)$child->$titleNodeName);
    }

    /**
     * Recursive Build Menu array
     *
     * @param Varien_Simplexml_Element $parent
     * @param string $path
     * @param int $level
     * @return array
     */
    protected function _buildMenuArray(Varien_Simplexml_Element $parent=null, $path='', $level=0)
    {
        if (is_null($parent)) {
            $parent = Mage::getSingleton('admin/config')->getAdminhtmlConfig()->getNode('menu');
        }
		
        $parentArr = array();
        $sortOrder = 0;
        foreach ($parent->children() as $childName => $child) {
            $aclResource = 'admin/' . ($child->resource ? (string)$child->resource : $path . $childName);
            //var_dump(!$this->_isEnabledModuleOutput($child));
            if (!$this->_checkAcl($aclResource) || !$this->_isEnabledModuleOutput($child)) {
               continue;
            }
			//var_dump($aclResource);
            if ($child->depends && !$this->_checkDepends($child->depends)) {
                continue;
            }

            $menuArr = array();
			
			$menuArr['code'] = $childName;
            $menuArr['label'] = $this->_getHelperValue($child);

            $menuArr['sort_order'] = $child->sort_order ? (int)$child->sort_order : $sortOrder;
            $menuArr['type'] = $child->type ? trim($child->type) : false;

            if ($child->action) {
                $menuArr['url'] = $this->_url->getUrl((string)$child->action, array('_cache_secret_key' => true));
            } else {
                $menuArr['url'] = '#';
                $menuArr['click'] = 'return false';
            }

            $menuArr['active'] = ($this->getActive()==$path.$childName)
                || (strpos($this->getActive(), $path.$childName.'/')===0);

            $menuArr['level'] = $level;

            if ($child->children) {
                $menuArr['children'] = $this->_buildMenuArray($child->children, $path.$childName.'/', $level+1);
            }
            $parentArr[$childName] = $menuArr;

            $sortOrder++;
        }

        uasort($parentArr, array($this, '_sortMenu'));

        while (list($key, $value) = each($parentArr)) {
            $last = $key;
        }
        if (isset($last)) {
            $parentArr[$last]['last'] = true;
        }

        return $parentArr;
    }

    /**
     * Sort menu comparison function
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function _sortMenu($a, $b)
    {
        return $a['sort_order']<$b['sort_order'] ? -1 : ($a['sort_order']>$b['sort_order'] ? 1 : 0);
    }

    /**
     * Check Depends
     *
     * @param Varien_Simplexml_Element $depends
     * @return bool
     */
    protected function _checkDepends(Varien_Simplexml_Element $depends)
    {
        if ($depends->module) {
            $modulesConfig = Mage::getConfig()->getNode('modules');
            foreach ($depends->module as $module) {
                if (!$modulesConfig->$module || !$modulesConfig->$module->is('active')) {
                    return false;
                }
            }
        }

        if ($depends->config) {
            foreach ($depends->config as $path) {
                if (!Mage::getStoreConfigFlag((string)$path)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check is Allow menu item for admin user
     *
     * @param string $resource
     * @return bool
     */
    protected function _checkAcl($resource)
    {
        try {
            $res =  Mage::getSingleton('admin/session')->isAllowed($resource);
        } catch (Exception $e) {
            return false;
        }
        return $res;
    }

    /**
     * Processing block html after rendering
     *
     * @param   string $html
     * @return  string
     */
    protected function _afterToHtml($html)
    {
        $html = preg_replace_callback('#'.Mage_Adminhtml_Model_Url::SECRET_KEY_PARAM_NAME.'/\$([^\/].*)/([^\$].*)\$#', array($this, '_callbackSecretKey'), $html);

        return $html;
    }

    /**
     * Replace Callback Secret Key
     *
     * @param array $match
     * @return string
     */
    protected function _callbackSecretKey($match)
    {
        return Mage_Adminhtml_Model_Url::SECRET_KEY_PARAM_NAME . '/'
            . $this->_url->getSecretKey($match[1], $match[2]);
    }

    /**
     * Get menu level HTML code
     *
     * @param array $menu
     * @param int $level
     * @return string
     */
    public function getMenuLevel($menu, $level = 0)
    {
        $html = '<ul ' . (!$level ? 'id="nav"' : '') . '>' . PHP_EOL;
        foreach ($menu as $item) {
        	
            $html .= '<li class="'
                . (!$level && !empty($item['active']) ? ' active' : '') . ' '
                . (!empty($item['children']) ? ' parent' : '')
                . (!empty($level) && !empty($item['last']) ? ' last' : '')
                . ' level' . $level . '"> <a href="' . $item['url'] . '" '
                . (!empty($item['title']) ? 'title="' . $item['title'] . '"' : '') . ' class="'
                . ($level === 0 && !empty($item['active']) ? 'active' : '') . '"><span>'
                
                . ($item['label']) . '</span>'
                //. ($level === 0 && !empty($item['children']) ? '<i class="fa fa-caret-down"></i>' : '')
				. '</a>' . PHP_EOL;

            if (!empty($item['children'])) {
                $html .= $this->getMenuLevel($item['children'], $level + 1);
            }
            $html .= '</li>' . PHP_EOL;
        }
        $html .= '</ul>' . PHP_EOL;

        return $html;
    }
    public function getApps() {
    	$menu = $this->getMenuArray();
    	foreach ($menu as $key => $item) {
        	if ($item['sort_order']<0) {
        		unset($menu[$key]);
        	}
    	}
    	return $menu;
    }
    public function getMenuLevelTrade($menu) {
    	$arr = array();
    	 foreach ($menu as $item) {
        	if ($item['type']!='trade') {
        		continue;
        	}
        	array_push($arr, $item);
    	 }
    	 return $this->getMenuLevelFirst($arr);
    }
    public function getMenuLevelBase($menu) {
    	$arr = array();
    	 foreach ($menu as $item) {
        	if ($item['type']=='trade') {
        		continue;
        	}
        	array_push($arr, $item);
    	 }
    	 return $this->getMenuLevelFirst($arr);
    }

    public function getMenuLevelFirst($menu)
    {
        $html = '<ul>' . PHP_EOL;
        foreach ($menu as $code => $item) {
        	//var_dump($menu);die();
        	if ($item['sort_order']<0) {
        		continue;
        	}
            $html .= '<li>'
                . '<a href="' . $item['url'] . '" '
                . (!empty($item['title']) ? ' title="' . $item['title'] . '"'  : '')
                
                . '><i class="fa fa-'.$item['code'].' mr5"></i><span>'. ($item['label']) . '</span>'
				. '</a>' . PHP_EOL;

            
            $html .= '</li>' . PHP_EOL;
        }
        $html .= '</ul>' . PHP_EOL;

        return $html;
    }

    /**
     * Check is module output enabled
     *
     * @param Varien_Simplexml_Element $child
     * @return bool
     */
    protected function _isEnabledModuleOutput(Varien_Simplexml_Element $child)
    {
        $helperName      = 'adminhtml';
        $childAttributes = $child->attributes();
        if (isset($childAttributes['module'])) {
            $helperName  = (string)$childAttributes['module'];
        }
		//echo '$helperName:'.$helperName;
        return Mage::helper($helperName)->isModuleOutputEnabled();
    }
}
