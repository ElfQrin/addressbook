<?
define('PAGETITLE','Address Book - Search');
include('site_header.php');

if ($functen['search']!=1) {fdisabled(); die();}
if (!auth_user('SEARCH')) {authdenied(); die();}

echo '<center>'.'<h1>'.'Search'.'</h1>'.'</center>';

include('dbsearch_form.inc.php'); echo "<br />\n";

include('site_footer.php');
?>