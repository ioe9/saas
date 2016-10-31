<?php
class Mage_Edm_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isUrl($s)  
    {  
	    return preg_match('/^http[s]?:\/\/'.  
	        '(([0-9]{1,3}\.){3}[0-9]{1,3}'. // IP形式的URL- 199.194.52.184  
	        '|'. // 允许IP和DOMAIN（域名）  
	        '([0-9a-z_!~*\'()-]+\.)*'. // 域名- www.  
	        '([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.'. // 二级域名  
	        '[a-z]{2,6})'.  // first level domain- .com or .museum  
	        '(:[0-9]{1,4})?'.  // 端口- :80  
	        '((\/\?)|'.  // a slash isn't required if there is no file name  
	        '(\/[0-9a-zA-Z_!~\'
	    \.;\?:@&=\+\$,%#-\/^\*\|]*)?)$/',  
	        $s) == 1;  
    }  
}
