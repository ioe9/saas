<?php
class Varien_Data_Form_Element_Editor extends Varien_Data_Form_Element_Textarea
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        if($this->isEnabled()) {
            $this->setType('wysiwyg');
            $this->setExtType('wysiwyg');
        } else {
            $this->setType('textarea');
            $this->setExtType('textarea');
        }
    }

    public function getElementHtml()
    {
        $js = '
            <script type="text/javascript">
            //<![CDATA[
                
            //]]>
            </script>';
        // add Firebug notice translations
        $warn = 'Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.';
        $this->getConfig()->addData(array(
            'firebug_warning_title'  => $this->translate('Warning'),
            'firebug_warning_text'   => $this->translate($warn),
            'firebug_warning_anchor' => $this->translate('Hide'),
        ));

        $jsSetupObject = 'wysiwyg' . $this->getHtmlId();

        $forceLoad = '';
        if (!$this->isHidden()) {
            if ($this->getForceLoad()) {
                $forceLoad = $jsSetupObject . '.setup("exact");';
            } else {
                $forceLoad = 'Event.observe(window, "load", '
                            . $jsSetupObject . '.setup.bind(' . $jsSetupObject . ', "exact"));';
            }
        }

        $html = '<textarea name="' . $this->getName() . '" title="' . $this->getTitle()
            . '" id="' . $this->getHtmlId() . '"'
            . ' class="textarea ' . $this->getClass() . '" '
            . $this->serialize($this->getHtmlAttributes()) . ' >' . $this->getEscapedValue() . '</textarea>'
            . $js . '
            <script type="text/javascript">'
                . 'CKEDITOR.replace("' . $this->getHtmlId() . '", { width:700, height:300 });'
            .'</script>';
		//Varien_Json::encode($this->getConfig())
        $html = $this->_wrapIntoContainer($html);
        $html .= $this->getAfterElementHtml();
        return $html;
        
    }
	
    protected function _wrapIntoContainer($html)
    {
        if (!$this->getConfig('use_container')) {
            return $html;
        }

        $html = '<div id="editor'.$this->getHtmlId().'"'
              . ($this->getConfig('no_display') ? ' style="display:none;"' : '')
              . ($this->getConfig('container_class') ? ' class="' . $this->getConfig('container_class') . '"' : '')
              . '>'
              . $html
              . '</div>';

        return $html;
    }


    /**
     * Editor config retriever
     *
     * @param string $key Config var key
     * @return mixed
     */
    public function getConfig($key = null)
    {
        if ( !($this->_getData('config') instanceof Varien_Object) ) {
            $config = new Varien_Object();
            $this->setConfig($config);
        }
        if ($key !== null) {
            return $this->_getData('config')->getData($key);
        }
        return $this->_getData('config');
    }

    /**
     * Translate string using defined helper
     *
     * @param string $string String to be translated
     * @return string
     */
    public function translate($string)
    {
        $translator = $this->getConfig('translator');
        if (method_exists($translator, '__')) {
            $result = $translator->__($string);
            if (is_string($result)) {
                return $result;
            }
        }

        return $string;
    }

    /**
     * Check whether Wysiwyg is enabled or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        if ($this->hasData('wysiwyg')) {
            return $this->getWysiwyg();
        }
        return $this->getConfig('enabled');
    }

    /**
     * Check whether Wysiwyg is loaded on demand or not
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->getConfig('hidden');
    }
}
