<?
define('PAGETITLE','Address Book - Remove all entries');
include('site_header.php');

if ($functen['remove']!=1) {fdisabled(); die();}
if (!auth_user('DELA')) {authdenied(); die();}

$delallm=strtolower(trim($_POST['delallm']));

echo '<center>'.'<h1>'.'Remove all entries'.'</h1>'.'</center>';

switch ($delallm) {
default:
echo 'Choose the requested action'.':'."<br />";
echo '<form name="console" id="console" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<input type="radio" name="delallm" value="entries" checked>'.'Delete all entries'."<br />";
echo '<input type="radio" name="delallm" value="table">'.'Remove the table from the database (it will have to be recreated)'."<br />";
echo '<input type="submit" value="'.'Delete all items'.'"';
if ($askc_dela) {echo ' onclick="javascript:return confirm(\''.'Are you sure?'.'\');" ';}
echo '/>';
echo '</form>';
break;
case 'entries':
$qdb="TRUNCATE TABLE `".$db_table1_name."`;"; # Empty a table
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
echo 'Address book emptied';
break;
case 'table':
$qdb="DROP TABLE `".$db_table1_name."`;"; # Delete a table
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
echo 'Address book\'s database table removed';
break;
}

include('site_footer.php');
?>