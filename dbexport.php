<?
$action='export';

$outfmt=strtolower(trim($_REQUEST['out'])); # txt, html, xml, json, csv
# if ($outfmt && $outfmt!='txt' && $outfmt!='html' && $outfmt!='xml' && $outfmt!='json') {$outfmt='csv';} # It's useless to sanitize input here because it has to be sanitized later
$outwhr=strtolower(trim($_REQUEST['put'])); # browser, dload
# if ($outwhr && $outwhr!='browser') {$outwhr='dload';} # It's useless to sanitize input here because it has to be sanitized later

if ($outwhr=='dload' && $outfmt) {
define('IN_ENGINE','1'); # test this static in includes to check if it has been invoked from the script: if (!defined('IN_ENGINE')) {die('forbidden');}
include('bios.inc.php');
include('dbshow.inc.php');
} else {
define('PAGETITLE','Address Book - Export');
include('site_header.php');

if ($functen['export']!=1) {fdisabled(); die();}
if (!auth_user('EXPORT')) {authdenied(); die();}

echo '<center>'.'<h1>'.'Export'.'</h1>'.'</center>';

if ($outfmt) {
include('dbshow.inc.php'); echo "<br />\n";
} else {
include('dbexport_form.inc.php');
}

include('site_footer.php');
}
?>