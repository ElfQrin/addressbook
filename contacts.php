<?
define('PAGETITLE','Contacts');
# include('ldir.php');
include('site_header.php');
?>

<center>
<h1><? echo 'Contacts'; ?></h1>

<p>
<?
echo 'E-mail'.':'.'<p>'.'<a href="mailto:'.$edge_webmaster_email.'?subject=['.$edge_project_name.']">'.$edge_webmaster_name."</a>";
?>

</center>

<?
include($dir_inc.'site_footer.php');
?>