<?
define('PAGETITLE','Address Book - Show');
include('site_header.php');

echo '<center>'.'<h1>'.'Show Item'.'</h1>'.'</center>';

$action='view';
$outfmt='webpage';
$outwhr='browser';

# Allowed fields (as set in the configuration file)
$usrfld='id,';
reset($dbdat);
while ($l_1=each($dbdat)) {
list ($l_1a,$l_1b) = $l_1['value'];
if ($l_1b>'0' && substr($l_1['key'],0,2)!='xx') {$usrfld.=$l_1['key'].',';}
}
$usrfld.='dat';
$qdbs1=$usrfld;

$id=addslashes(trim($_REQUEST['id']));

include('dbshowitem.inc.php');

include('site_footer.php');
?>