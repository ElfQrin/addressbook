<? if (!defined('IN_ENGINE')) {die('forbidden');}
# die();
# Check for mobile devices
if (preg_match('/(pre\/|mobi|symbian|windows ce|samsung-sgh|fennec|palm|avantgo|hiptop|plucker|xiino|blazer|elaine)/i',$_SERVER['HTTP_USER_AGENT'])) {$mobi=true;} else {$mobi=false;}
include('config_x.inc.php');
include('functions.php');
include('functions_db.php');

$dbxcon=dbx_connect($dbx,$db_host,$db_user,$db_pwd,$db_name);

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
?>