<?
// Determines platform (OS), browser and version of the user
// Based on a phpBuilder article:
//   see http://www.phpbuilder.net/columns/tim20000821.php
if (!defined('PMA_USR_OS')) {
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    } else if (!isset($HTTP_USER_AGENT)) {
        $HTTP_USER_AGENT = '';
    }

    // 1. Platform
    if (strstr($HTTP_USER_AGENT, 'Win')) {
        define('PMA_USR_OS', 'Win');
    } else if (strstr($HTTP_USER_AGENT, 'Mac')) {
        define('PMA_USR_OS', 'Mac');
    } else if (strstr($HTTP_USER_AGENT, 'Linux')) {
        define('PMA_USR_OS', 'Linux');
    } else if (strstr($HTTP_USER_AGENT, 'Unix')) {
        define('PMA_USR_OS', 'Unix');
    } else if (strstr($HTTP_USER_AGENT, 'OS/2')) {
        define('PMA_USR_OS', 'OS/2');
    } else {
        define('PMA_USR_OS', 'Other');
    }

    // 2. browser and version
    // (must check everything else before Mozilla)

    if (preg_match('@Opera(/| )([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
        define('PMA_USR_BROWSER_VER', $log_version[2]);
        define('PMA_USR_BROWSER_AGENT', 'OPERA');
    } else if (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
        define('PMA_USR_BROWSER_VER', $log_version[1]);
        define('PMA_USR_BROWSER_AGENT', 'IE');
    } else if (preg_match('@OmniWeb/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
        define('PMA_USR_BROWSER_VER', $log_version[1]);
        define('PMA_USR_BROWSER_AGENT', 'OMNIWEB');
    //} else if (preg_match("@Konqueror/([0-9].[0-9]{1,2})@", $HTTP_USER_AGENT, $log_version)) {
    // Konqueror 2.2.2 says Konqueror/2.2.2
    // Konqueror 3.0.3 says Konqueror/3
    } else if (preg_match('@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version)) {
        define('PMA_USR_BROWSER_VER', $log_version[2]);
        define('PMA_USR_BROWSER_AGENT', 'KONQUEROR');
    } else if (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)
               && preg_match('@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2)) {
        define('PMA_USR_BROWSER_VER', $log_version[1] . '.' . $log_version2[1]);
        define('PMA_USR_BROWSER_AGENT', 'SAFARI');
    } else if (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
        define('PMA_USR_BROWSER_VER', $log_version[1]);
        define('PMA_USR_BROWSER_AGENT', 'MOZILLA');
    } else {
        define('PMA_USR_BROWSER_VER', 0);
        define('PMA_USR_BROWSER_AGENT', 'OTHER');
    }
}

?>