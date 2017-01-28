<? if (!defined('IN_ENGINE')) {die('forbidden');}

# $id and $qdbs1 must be set before to include this file
# $qdbs1='*';
$qdb='SELECT '.$qdbs1." FROM `".$db_table1_name."` WHERE `id`=".$id.";";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$dbi=dbx_fetch_array($dbx,$dbo);
$dbn=dbx_num_rows($dbx,$dbo);

if ($dbn>0) {
$dbi['bdayd'] = substr($dbi['bday'],6,2);
$dbi['bdaym'] = substr($dbi['bday'],4,2);
$dbi['bdayy'] = substr($dbi['bday'],0,4);
} else {
include('getdata_1_default.inc.php');
}

?>