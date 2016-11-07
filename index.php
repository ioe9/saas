<?php
/***
 * @copyright www.ieo9.com
 * @author Gary Yang
 */

if (version_compare(phpversion(), '5.3.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">对不起，您的PHP版本太低 > 5.3.0 </div>';
    exit;
}

/**
 * Compilation includes configuration file
 */
define('MAGE_ROOT', getcwd());
define('MAGE_TYPE','standard'); //standard 标准版 shop 商城版
define('MAGE_UPDATE',false);
define('MAGE_HOST','http://saas.ioe9.com/');

$compilerConfig = MAGE_ROOT . '/includes/config.php';
if (file_exists($compilerConfig)) {
    include $compilerConfig;
}

$mageFilename = MAGE_ROOT . '/app/Mage.php';
$maintenanceFile = 'maintenance.flag';

if (file_exists($maintenanceFile)) {
    include_once dirname(__FILE__) . '/errors/503.php';
    exit;
}

if (function_exists('libxml_disable_entity_loader')) {
    libxml_disable_entity_loader(false);
}
require_once $mageFilename;

Varien_Profiler::enable();

if (isset($_SERVER['MAGE_IS_DEVELOPER_MODE'])) {
    Mage::setIsDeveloperMode(true);
}

ini_set('display_errors', 1);
umask(0);
date_default_timezone_set('PRC'); //设置时区
Mage::run();

?>

