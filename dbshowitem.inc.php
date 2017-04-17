<? if (!defined('IN_ENGINE')) {die('forbidden');}

include_once('functions_showitem.php');

$qdb='SELECT '.$qdbs1." FROM `".$db_table1_name."`"." WHERE `id`='".$id."' LIMIT 1;";
# echo "<br />".'['.$qdb.']'."<br />";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
if ($dbo) {
include('dbshow_header.inc.php');
$dbey=dbx_fetch_array($dbx,$dbo);
$cp=1;
include('dbshow_body.inc.php');

include('dbshow_footer.inc.php');
}

if ($action=='edit') {
$iid=$id;
$ou='';
# $ou.=' '.'ID'.':'.$iid;
if (auth_user('DEL1')) {
$ou.=' '.'<a href="'.'dbshow.php?action=edit&del='.$iid.'"';
if ($askc_del1) {$ou.=' onclick="javascript:return confirm(\''.'Are you sure?'.'\');" ';}
$ou.='>'.'Del'.'</a>';
}
if (auth_user('EDIT')) {
$ou.=' '.'<a href="'.'dbadd.php?action=edit&id='.$iid.'">'.'Edit'.'</a>';
}
if (auth_user('STAR1')) {
$ou.=' '.'<a href="'.'dbshow.php?action=edit&fav='.$iid.'">'.'Fav'.'</a>';
}
echo "<br />".$ou."<br />\n";
}

?>