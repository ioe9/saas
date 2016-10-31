<?php
class Mage_Edm_Helper_Whois
{
    private $domain;

    private $TLDs;

    private $subDomain;

    private $servers;

    /**
     * @param string $domain full domain name (without trailing dot)
     */
    public function init($domain)
    {
    	$domain = $this->getTopDomain($domain);
        $this->domain = $domain;
        // check $domain syntax and split full domain name on subdomain and TLDs
        if (
            preg_match('/^([\p{L}\d\-]+)\.((?:[\p{L}\-]+\.?)+)$/ui', $this->domain, $matches)
            || preg_match('/^(xn\-\-[\p{L}\d\-]+)\.(xn\-\-(?:[a-z\d-]+\.?1?)+)$/ui', $this->domain, $matches)
        ) {
            $this->subDomain = $matches[1];
            $this->TLDs = $matches[2];
        } else {
        	
        }
            
        // setup whois servers array from json file
        $this->servers = json_decode(file_get_contents( __DIR__.'/whois.servers.json' ), true);
    	return $this;
    }

    public function info()
    {
        if ($this->isValid()) {
            $whois_server = $this->servers[$this->TLDs][0];

            // If TLDs have been found
            if ($whois_server != '') {

                // if whois server serve replay over HTTP protocol edmtead of WHOIS protocol
                if (preg_match("/^https?:\/\//i", $whois_server)) {

                    // curl session to get whois reposnse
                    $ch = curl_init();
                    $url = $whois_server . $this->subDomain . '.' . $this->TLDs;
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                    $data = curl_exec($ch);

                    if (curl_error($ch)) {
                        return "Connection error!";
                    } else {
                        $string = strip_tags($data);
                    }
                    curl_close($ch);

                } else {

                    // Getting whois information
                    $fp = fsockopen($whois_server, 43);
                    if (!$fp) {
                        return "Connection error!";
                    }

                    $dom = $this->subDomain . '.' . $this->TLDs;
                    fputs($fp, "$dom\r\n");

                    // Getting string
                    $string = '';

                    // Checking whois server for .com and .net
                    if ($this->TLDs == 'com' || $this->TLDs == 'net') {
                        while (!feof($fp)) {
                            $line = trim(fgets($fp, 128));

                            $string .= $line;

                            $lineArr = explode (":", $line);

                            if (strtolower($lineArr[0]) == 'whois server') {
                                $whois_server = trim($lineArr[1]);
                            }
                        }
                        // Getting whois information
                        $fp = fsockopen($whois_server, 43);
                        if (!$fp) {
                            return "Connection error!";
                        }

                        $dom = $this->subDomain . '.' . $this->TLDs;
                        fputs($fp, "$dom\r\n");

                        // Getting string
                        $string = '';

                        while (!feof($fp)) {
                            $string .= fgets($fp, 128);
                        }

                        // Checking for other tld's
                    } else {
                        while (!feof($fp)) {
                            $string .= fgets($fp, 128);
                        }
                    }
                    fclose($fp);
                }

                $string_encoding = mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true);
                $string_utf8 = mb_convert_encoding($string, "UTF-8", $string_encoding);

                return htmlspecialchars($string_utf8, ENT_COMPAT, "UTF-8", true);
            } else {
                return "No whois server for this tld in list!";
            }
        } else {
            return "Domain name isn't valid!";
        }
    }

    public function htmlInfo()
    {
        return nl2br($this->info());
    }

    /**
     * @return string full domain name
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string top level domaedm separated by dot
     */
    public function getTLDs()
    {
        return $this->TLDs;
    }

    /**
     * @return string return subdomain (low level domain)
     */
    public function getSubDomain()
    {
        return $this->subDomain;
    }

    public function isAvailable()
    {
        $whois_string = $this->info();
        $not_found_string = '';
        if (isset($this->servers[$this->TLDs][1])) {
           $not_found_string = $this->servers[$this->TLDs][1];
        }

        $whois_string2 = @preg_replace('/' . $this->domain . '/', '', $whois_string);
        $whois_string = @preg_replace("/\s+/", ' ', $whois_string);

        $array = explode (":", $not_found_string);
        if ($array[0] == "MAXCHARS") {
            if (strlen($whois_string2) <= $array[1]) {
                return true;
            } else {
                return false;
            }
        } else {
            if (preg_match("/" . $not_found_string . "/i", $whois_string)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isValid()
    {
        if (
            isset($this->servers[$this->TLDs][0])
            && strlen($this->servers[$this->TLDs][0]) > 6
        ) {
            $tmp_domain = strtolower($this->subDomain);
            if (
                preg_match("/^[a-z0-9\-]{3,}$/", $tmp_domain)
                && !preg_match("/^-|-$/", $tmp_domain) //&& !preg_match("/--/", $tmp_domain)
            ) {
                return true;
            }
        }

        return false;
    }
    
    
    public function getTopDomain($domain) {  
	    $domain = $this->getRegularDomain( $domain );  
	    $iana_root = array (  
	            'ac',  
	            'ad',  
	            'ae',  
	            'aero',  
	            'af',  
	            'ag',  
	            'ai',  
	            'al',  
	            'am',  
	            'an',  
	            'ao',  
	            'aq',  
	            'ar',  
	            'arpa',  
	            'as',  
	            'asia',  
	            'at',  
	            'au',  
	            'aw',  
	            'ax',  
	            'az',  
	            'ba',  
	            'bb',  
	            'bd',  
	            'be',  
	            'bf',  
	            'bg',  
	            'bh',  
	            'bi',  
	            'biz',  
	            'bj',  
	            'bl',  
	            'bm',  
	            'bn',  
	            'bo',  
	            'bq',  
	            'br',  
	            'bs',  
	            'bt',  
	            'bv',  
	            'bw',  
	            'by',  
	            'bz',  
	            'ca',  
	            'cat',  
	            'cc',  
	            'cd',  
	            'cf',  
	            'cg',  
	            'ch',  
	            'ci',  
	            'ck',  
	            'cl',  
	            'cm',  
	            'cn',  
	            'co',  
	            'com',  
	            'coop',  
	            'cr',  
	            'cu',  
	            'cv',  
	            'cw',  
	            'cx',  
	            'cy',  
	            'cz',  
	            'de',  
	            'dj',  
	            'dk',  
	            'dm',  
	            'do',  
	            'dz',  
	            'ec',  
	            'edu',  
	            'ee',  
	            'eg',  
	            'eh',  
	            'er',  
	            'es',  
	            'et',  
	            'eu',  
	            'fi',  
	            'fj',  
	            'fk',  
	            'fm',  
	            'fo',  
	            'fr',  
	            'ga',  
	            'gb',  
	            'gd',  
	            'ge',  
	            'gf',  
	            'gg',  
	            'gh',  
	            'gi',  
	            'gl',  
	            'gm',  
	            'gn',  
	            'gov',  
	            'gp',  
	            'gq',  
	            'gr',  
	            'gs',  
	            'gt',  
	            'gu',  
	            'gw',  
	            'gy',  
	            'hk',  
	            'hm',  
	            'hn',  
	            'hr',  
	            'ht',  
	            'hu',  
	            'id',  
	            'ie',  
	            'il',  
	            'im',  
	            'in',  
	            'info',  
	            'int',  
	            'io',  
	            'iq',  
	            'ir',  
	            'is',  
	            'it',  
	            'je',  
	            'jm',  
	            'jo',  
	            'jobs',  
	            'jp',  
	            'ke',  
	            'kg',  
	            'kh',  
	            'ki',  
	            'km',  
	            'kn',  
	            'kp',  
	            'kr',  
	            'kw',  
	            'ky',  
	            'kz',  
	            'la',  
	            'lb',  
	            'lc',  
	            'li',  
	            'lk',  
	            'lr',  
	            'ls',  
	            'lt',  
	            'lu',  
	            'lv',  
	            'ly',  
	            'ma',  
	            'mc',  
	            'md',  
	            'me',  
	            'mf',  
	            'mg',  
	            'mh',  
	            'mil',  
	            'mk',  
	            'ml',  
	            'mm',  
	            'mn',  
	            'mo',  
	            'mobi',  
	            'mp',  
	            'mq',  
	            'mr',  
	            'ms',  
	            'mt',  
	            'mu',  
	            'museum',  
	            'mv',  
	            'mw',  
	            'mx',  
	            'my',  
	            'mz',  
	            'na',  
	            'name',  
	            'nc',  
	            'ne',  
	            'net',  
	            'nf',  
	            'ng',  
	            'ni',  
	            'nl',  
	            'no',  
	            'np',  
	            'nr',  
	            'nu',  
	            'nz',  
	            'om',  
	            'org',  
	            'pa',  
	            'pe',  
	            'pf',  
	            'pg',  
	            'ph',  
	            'pk',  
	            'pl',  
	            'pm',  
	            'pn',  
	            'pr',  
	            'pro',  
	            'ps',  
	            'pt',  
	            'pw',  
	            'py',  
	            'qa',  
	            're',  
	            'ro',  
	            'rs',  
	            'ru',  
	            'rw',  
	            'sa',  
	            'sb',  
	            'sc',  
	            'sd',  
	            'se',  
	            'sg',  
	            'sh',  
	            'si',  
	            'sj',  
	            'sk',  
	            'sl',  
	            'sm',  
	            'sn',  
	            'so',  
	            'sr',  
	            'ss',  
	            'st',  
	            'su',  
	            'sv',  
	            'sx',  
	            'sy',  
	            'sz',  
	            'tc',  
	            'td',  
	            'tel',  
	            'tf',  
	            'tg',  
	            'th',  
	            'tj',  
	            'tk',  
	            'tl',  
	            'tm',  
	            'tn',  
	            'to',  
	            'tp',  
	            'tr',  
	            'travel',  
	            'tt',  
	            'tv',  
	            'tw',  
	            'tz',  
	            'ua',  
	            'ug',  
	            'uk',  
	            'um',  
	            'us',  
	            'uy',  
	            'uz',  
	            'va',  
	            'vc',  
	            've',  
	            'vg',  
	            'vi',  
	            'vn',  
	            'vu',  
	            'wf',  
	            'ws',  
	            'xxx',  
	            'ye',  
	            'yt',  
	            'za',  
	            'zm',  
	            'zw'   
	    );  
	    $sub_domain = explode ( '.', $domain );  
	    $top_domain = '';  
	    $top_domain_count = 0;  
	    for($i = count ( $sub_domain ) - 1; $i >= 0; $i --) {  
	        if ($i == 0) {  
	            // just in case of something like NAME.COM  
	            break;  
	        }  
	        if (in_array ( $sub_domain [$i], $iana_root )) {  
	            $top_domain_count ++;  
	            $top_domain = '.' . $sub_domain [$i] . $top_domain;  
	            if ($top_domain_count >= 2) {  
	                break;  
	            }  
	        }  
	    }  
	    $top_domain = $sub_domain [count ( $sub_domain ) - $top_domain_count - 1] . $top_domain;  
	    return $top_domain;  
	}  
	
	function getRegularDomain($domain) 
	{
	  if (substr ( $domain, 0, 7 ) == 'http://') {
	    $domain = substr ( $domain, 7 );
	  }
	  if (strpos ( $domain, '/' ) !== false) {
	    $domain = substr ( $domain, 0, strpos ( $domain, '/' ) );
	  }
	  return strtolower ( $domain );
	}
	
	public function getValueByKey($key) {
		$info = $this->info();
		foreach (explode("\n",$info) as $_v) {
			$tmp = explode(':',$_v);
			//echo $tmp[0]."<br/>";
			if ($key==$tmp[0]) {
				return $tmp[1];
			}
		} 
		return null;
	}
}
