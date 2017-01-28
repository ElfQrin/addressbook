<?
define('PAGETITLE','Address Book - List');
include('site_header.php');

$action=strtolower(trim($_REQUEST['action'])); # Action (View, Edit)
if ($action!='edit' && $action!='export') {$action='view';}

if ($action=='view') {
if ($functen['view']!=1) {fdisabled(); die();}
echo '<center>'.'<h1>'.'List all entries'.'</h1>'.'</center>';
} else {
if ($functen['edit']!=1) {fdisabled(); die();}
if (!auth_user('EDIT')) {authdenied(); die();}
echo '<center>'.'<h1>'.'Edit entries'.'</h1>'.'</center>';
}

include('dbshow.inc.php');

include('site_footer.php');
?>