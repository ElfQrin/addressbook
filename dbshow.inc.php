<? if (!defined('IN_ENGINE')) {die('forbidden');}

include('functions_showitem.php');

function fmtcheckbox($outfmt,$iid) {
global $askc_del1;
$ou='';
switch ($outfmt) {
case 'webpage':
$ou.='<tr>'.'<td>';
break;
case 'webpage_list':
$ou.='<td>';
break;
}
$ou.='<input type="checkbox" name="'.'selitem[]'.'" value="'.$iid.'" />';
# $ou.=' '.'ID'.':'.$iid;
$ou.=' '.'<a href="'.'dbshowitem.php?action=edit&id='.$iid.'">'.'ID'.':'.$iid.'</a>';
if (auth_user('DEL1')) {
$ou.=' '.'<a href="'.'dbshow.php?action=edit&del='.$iid.'"';
if ($askc_del1) {$ou.=' onclick="javascript:return confirm(\''.'Are you sure?'.'\');" ';}
$ou.='>'.'Del'.'</a>';
}
if (auth_user('EDIT')) {
$ou.=' '.'<a href="'.'dbadd.php?action=edit&id='.$iid.'">'.'Edit'.'</a>';
}
if ($starr && auth_user('STAR1')) {
$ou.=' '.'<a href="'.'dbshow.php?action=edit&fav='.$iid.'">'.'Fav'.'</a>';
}
switch ($outfmt) {
case 'webpage':
$ou.='</td>'.'</tr>';
break;
case 'webpage_list':
$ou.='</td>';
break;
}
return $ou;
}

function shwctrlbuttons() {
global $mobi,$starr;
# include('functions_js_checkbox.inc.php');
echo '
<script language="JavaScript" type="text/javascript">
<!--
drawSelItmButtons();
// if (window.innerWidth<400) {document.writeln("<br />");}
// -->
</script>
 ';
if (auth_user('DELM')) {
echo '<input type="submit" name="cdel" value="';
if ($mobi) {echo 'Del';} else {echo 'Delete';}
echo '" /> ';
}
if ($starr && auth_user('STARM')) {
echo '<input type="submit" name="cstar" value="'.'Fav+'.'" /> ';
echo '<input type="submit" name="cunstar" value="'.'Fav-'.'" /> ';
}
}

# $action=strtolower(trim($_REQUEST['action'])); # Action (View, Edit) # Commented out because it's defined before to include this file
$outfmt=strtolower(trim($_REQUEST['out'])); # Output format (webpage, webpage_list, raw, txt, html, xml, json, csv)
$outwhr=strtolower(trim($_REQUEST['put'])); # Where to put the output (browser, dload)

if (!$action) {$action='view';} # Set default action
if (($action=='view' && $functen['view']!=1) || ($action=='edit' && $functen['edit']!=1) || ($action=='export' && $functen['export']!=1)) {fdisabled(); die();}
if ($action=='export' && !auth_user('EXPORT')) {authdenied(); die();}
if ($action=='export' || $outfmt=='raw') {$reslim=false;} else {$reslim=$reslimdef;}

if (!$outfmt) {
if ($action=='edit') {
$outfmt='webpage_list';
} else {
$outfmt='webpage';
}
} # Set default output format
if ($outwhr!='dload' || $outfmt=='webpage' || $action=='edit') {$outwhr='browser';} # Set default for Where to put the output / Download not allowed for webpage format and edit
if ($action=='export' && $outfmt!='txt' && $outfmt!='html' && $outfmt!='xml' && $outfmt!='json') {$outfmt='csv';} # Set allowed formats and default format to export data
if ($action=='export' && $outwhr!='browser') {$outwhr='dload';} # Set default destination to export data
if ($outfmt=='raw') {$outfmt='txt';} # You may want to use "raw" for testing purposes only. Set this line as a comment to prevent raw output of the table in the database, or comment it out to allow it

if (!$pag) {$pag=$_GET['pag'];}
if (!$pag || $pag<1) {$pag=1;}
if (!$itmppag) {$itmppag=$_GET['itmppag'];}
if (!preg_match("/^[0-9]+$/i",$itmppag)) {$itmppag=$itmppagdef;} # Prevents MySQL injection
if (!$itmppag || $itmppag<1 || $itmppag>=$itmppagdef) {$itmppag=$itmppagdef;}
# $itmppag=3; # Force items per page

$_frm=$pag*$itmppag-$itmppag;
# $pagurl=$edge_main_url.'dbshow.php';
$pagurl=$_REQUEST['PHP_SELF'];


# Deletion
$del=checkint($_GET['del']);
if ($del) {
if (auth_user('DEL1')) {
$qdb="DELETE FROM `".$db_table1_name."` WHERE `id`=".$del.";";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
# echo 'Entry deleted';
} else {authdenied();}
}

# Star/Unstar
if ($starr) {
$fav=checkint($_GET['fav']);
if ($fav) {
if (auth_user('STAR1')) {
$qdb="SELECT `starr` FROM `".$db_table1_name."` WHERE `id`=".$fav.";";
# echo "<br />".'*** 1: ['.$qdb.']'."<br />";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
if ($row['starr']==0) {$xinv=1;} else {$xinv=0;}
$qdb="UPDATE `".$db_table1_name."` SET `starr`=".$xinv." WHERE `id`=".$fav.";";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
# echo 'Entry starred';
} else {authdenied();}
}
}


$selitem=$_REQUEST['selitem'];
if ($selitem && (auth_user('DELM') || ($starr && auth_user('STARM')))) {

for ($icnt=0; $icnt<count($selitem); $icnt++) {
$selitem[$icnt]=floor($selitem[$icnt]);

# Mass Deletion
if (auth_user('DELM') && $_POST['cdel']!='') {
$qdb="DELETE FROM `".$db_table1_name."` WHERE id=".$selitem[$icnt].";";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
# echo 'Mass deletion performed';
}

if ($starr && auth_user('STARM')) {
# Mass Star
if ($_POST['cstar']!='') {
$qdb="UPDATE `".$db_table1_name."` SET `starr`=".'1'." WHERE `id`=".$selitem[$icnt].";";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
# echo 'Mass deletion performed';
}

# Mass Unstar
if ($_POST['cunstar']!='') {
$qdb="UPDATE `".$db_table1_name."` SET `starr`=".'0'." WHERE `id`=".$selitem[$icnt].";";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
# echo 'Mass deletion performed';
}
}

}

}


if ($outwhr=='browser' && ($outfmt=='webpage' || $outfmt=='webpage_list')) {
include('dbsearch_form.inc.php'); echo "<br />\n";
}

# Set default file name and extension
switch ($outfmt) {
default:
case 'txt':
case 'raw':
$fout='data.txt';
break;
case 'html':
$fout='data.html';
break;
case 'csv':
$fout='data.csv';
break;
case 'xml':
$fout='data.xml';
break;
case 'json':
$fout='data.json';
break;
}

# Allowed fields (as set in the configuration file)
$usrfld='id,';
reset($dbdat);
while ($l_1=each($dbdat)) {
list ($l_1a,$l_1b) = str_getcsv($l_1['value'],'|');
if ($l_1b>'0' && substr($l_1['key'],0,2)!='xx') {$usrfld.=$l_1['key'].',';}
}
$usrfld.='dat';

$qusrch='';
include('getdatasearch_1_form.inc.php');

$qusrt='';

if ($q && strlen($q)<$srchqminlen && ($outfmt=='webpage' || $outfmt=='webpage_list')) {echo 'You need to provide at least '.$srchqminlen.' characters to search into the database'."<br /><br />\n";}

if ($outfmt!='raw') {
$qdbs1=$usrfld;
} else {
$qdbs1='*';
}

if ($starr) {
if ($starrbl==1) {
$qusrt.=' ORDER BY `starr` DESC';
if ($defsrt) {$qusrt.=', '.$defsrt;}
} elseif ($starrbl==2) {
$qusrt.=' ORDER BY `starr` ASC';
if ($defsrt) {$qusrt.=', '.$defsrt;}
}
} else {
if ($defsrt) {$qusrt.=' ORDER BY '.$defsrt;}
}

$qcnt='SELECT COUNT(*) AS c'." FROM `".$db_table1_name."`".$qusrch;
$qdb='SELECT '.$qdbs1." FROM `".$db_table1_name."`".$qusrch;
$qdb.=$qusrt;
if ($reslim) {$qdb.=" LIMIT ".$_frm.",".$itmppag;}
$qdb.=';';
# echo "<br />".'['.$qdb.']'."<br />";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
# $dbn=dbx_num_rows($dbx,$dbo);

if ($dbo) {

$fwhandle='';
if ($outwhr=='dload') {
include('savehdr.inc.php'); // Ask user where to save the file
// if (!$fwhandle=fopen($fout,'w')) {echo "Can't open file for output."; die();} // Save a file locally
} else {
# echo "<br />".'['.$qcnt.']'."<br />";
$qnum=dbx_query($dbx,$dbxcon,$qcnt,$db_name);
$qnrn=dbx_fetch_array($dbx,$qnum); $qnr=$qnrn['c'];
# echo "<br />".'['.$qnr.']'."<br />";

if ($outwhr=='browser' && $outfmt!='webpage' && $outfmt!='webpage_list') {
echo '<code><xmp>';
}

if ($outwhr=='browser' && ($outfmt=='webpage' || $outfmt=='webpage_list')) {
if ($qnr!=1) {$wxsp='entries';} else {$wxsp='entry';}; echo $qnr.' '.$wxsp.' '.'found'."<br />";
# if ($dbn!=1) {$wxsp='entries';} else {$wxsp='entry';}; echo $dbn.' '.$wxsp.' '.'listed'."<br />";
echo "<br />\n";
}

if ($reslim) {
prpagnum($pag,$itmppag,$qnr,$pagurl,'?out='.$outfmt.'&put='.$outwhr.'&itmppag='.$itmppag.'&');
echo "<br /><br />";
}

}

$showeft=$showef; # Show/Hide empty field as requested in the configuration. If an output format doesn't allow it, you can override it here

if ($action=='edit') {$useminimitems=true;} else {$useminimitems=false;}
if ($action=='edit') {$shwctrls=true;} else {$shwctrls=false;}


if ($shwctrls && auth_user('DELM,STARM','|')) {
include('functions_js_checkbox.inc.php');
echo '<form name="console" id="console" action="'.$_REQUEST['PHP_SELF'].'" method="post">';
shwctrlbuttons();
}

include('dbshow_header.inc.php');

$cp=0;
while ($dbey=dbx_fetch_array($dbx,$dbo)) {
$cp++;
include('dbshow_body.inc.php');
}

include('dbshow_footer.inc.php');

if ($shwctrls && auth_user('DELM,STARM','|')) {
shwctrlbuttons();
echo '</form>';
}


if ($outwhr=='dload') {
// fclose($fwhandle);
} else {
if ($outwhr=='browser' && $outfmt!='webpage' && $outfmt!='webpage_list') {
echo '</xmp></code>';
}

if ($reslim) {
echo "<br /><br />";
prpagnum($pag,$itmppag,$qnr,$pagurl,'?out='.$outfmt.'&put='.$outwhr.'&itmppag='.$itmppag.'&');
}

}

}

if ($action=='edit' && $functen['remove']==1 && auth_user('DELA')) {echo "<br /><br />".'<a href="dbremove.php">Remove all entries from the database</a>';}

?>