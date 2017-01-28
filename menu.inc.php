<? if (!defined('IN_ENGINE')) {die('forbidden');} ?>

<table border="0" align="center" cellpadding="3" cellspacing="3">
<tr>
<?
if ($functen['create']==1) {echo '<td align="center"><a href="dbcreate.php">Create</a></td>';}
if ($functen['add']==1) {echo '<td align="center"><a href="dbadd.php">Add</a></td>';}
if ($functen['edit']==1) {echo '<td align="center"><a href="dbshow.php?action=edit">Edit</a></td>';}
if ($functen['view']==1) {echo '<td align="center"><a href="dbshow.php?action=view">List</a></td>';}
if ($functen['search']==1) {echo '<td align="center"><a href="dbsearch.php">Search</a></td>';}
if ($functen['export']==1) {echo '<td align="center"><a href="dbexport.php">Export</a></td>';}
if ($functen['stats']==1) {echo '<td align="center"><a href="dbstats.php">Stats</a></td>';}
# if ($functen['remove']==1) {echo '<td align="center"><a href="dbremove.php">Remove</a></td>';}
?>
</tr>
</table>
