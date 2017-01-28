<?
define('PAGETITLE','Address Book - Stats');
include('site_header.php');

if ($functen['stats']!=1) {fdisabled(); die();}

echo '<center>'.'<h1>'.'Stats'.'</h1>'.'</center>';

$qdb="SELECT COUNT(*) AS c FROM `".$db_table1_name."`;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Total entries'.': '.$row['c']."<br /><br />";

$cfk='name';
# $qdb="SELECT MIN(LENGTH(".$cfk.")) AS d FROM `".$db_table1_name."`;"; # Get lenght only, without the value
$qdb="SELECT ".$cfk." FROM `".$db_table1_name."` WHERE LENGTH(".$cfk.") IN (SELECT MIN(LENGTH(".$cfk.")) FROM `".$db_table1_name."`);";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Shortest Name'.': '.$row[$cfk].' ('.strlen($row[$cfk]).' '.'characters'.')'."<br /><br />";

$cfk='name';
# $qdb="SELECT MAX(LENGTH(".$cfk.")) AS d FROM `".$db_table1_name."`;"; # Get lenght only, without the value
$qdb="SELECT ".$cfk." FROM `".$db_table1_name."` WHERE LENGTH(".$cfk.") IN (SELECT MAX(LENGTH(".$cfk.")) FROM `".$db_table1_name."`);";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Longest Name'.': '.$row[$cfk].' ('.strlen($row[$cfk]).' '.'characters'.')'."<br /><br />";

$cfk='lname';
# $qdb="SELECT MIN(LENGTH(".$cfk.")) AS d FROM `".$db_table1_name."`;"; # Get lenght only, without the value
$qdb="SELECT ".$cfk." FROM `".$db_table1_name."` WHERE LENGTH(".$cfk.") IN (SELECT MIN(LENGTH(".$cfk.")) FROM `".$db_table1_name."`);";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Shortest Last Name'.': '.$row[$cfk].' ('.strlen($row[$cfk]).' '.'characters'.')'."<br /><br />";

$cfk='lname';
# $qdb="SELECT MAX(LENGTH(".$cfk.")) AS d FROM `".$db_table1_name."`;"; # Get lenght only, without the value
$qdb="SELECT ".$cfk." FROM `".$db_table1_name."` WHERE LENGTH(".$cfk.") IN (SELECT MAX(LENGTH(".$cfk.")) FROM `".$db_table1_name."`);";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Longest Last Name'.': '.$row[$cfk].' ('.strlen($row[$cfk]).' '.'characters'.')'."<br /><br />";

$cfk='bday';
$qdb="SELECT MIN(".$cfk.") AS d FROM `".$db_table1_name."`;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Oldest Birthday'.': '.dateread($row['d'])."<br /><br />";

$cfk='bday';
$qdb="SELECT MAX(".$cfk.") AS d FROM `".$db_table1_name."`;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
echo 'Earliest Birthday'.': '.dateread($row['d'])."<br /><br />";

include('site_footer.php');
?>