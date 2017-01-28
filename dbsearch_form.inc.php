<? if (!defined('IN_ENGINE')) {die('forbidden');}

if ($functen['search']==1 && auth_user('SEARCH')) {
echo '<form name="search" id="search" action="'.'dbshow.php'.'" method="post">';
if ($action=='edit') {echo 'Filter';} else {echo 'Search';}; echo ' ';
echo '<input type="search" name="q" value="" autofocus /> ';
echo '<input type="hidden" name="action" value="'.$action.'" />';
echo '<input type="submit" value="'.'Search'.'" />';
echo '</form>';
}

?>