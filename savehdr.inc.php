<? if (!defined('IN_ENGINE')) {die('forbidden');}
include('idplatform.inc.php');

# 'application/octet-stream' is the registered IANA type but MSIE and Opera seems to prefer 'application/octetstream'
$mime_type = (PMA_USR_BROWSER_AGENT == 'IE' || PMA_USR_BROWSER_AGENT == 'OPERA')?'application/octetstream':'application/octet-stream';

header("Content-type: ".$mime_type);

if (PMA_USR_BROWSER_AGENT == 'IE') {
header('Content-Disposition: inline; filename="'.$fout.'"');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
} else {
header('Content-Disposition: attachment; filename="'.$fout.'"');
header('Pragma: no-cache');
}

?>