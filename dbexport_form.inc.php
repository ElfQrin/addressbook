<? if (!defined('IN_ENGINE')) {die('forbidden');}

if ($functen['export']==1 && auth_user('EXPORT')) {
echo '<form name="export" id="export" action="'.'dbexport.php'.'" method="post">';
echo 'Export'.': ';
echo 'Format'.' ';
echo '<select name="out">';
echo '<option value="txt">'.'Text'.'</option>';
echo '<option value="html">'.'HTML'.'</option>';
echo '<option value="xml">'.'XML'.'</option>';
echo '<option value="json">'.'JSON'.'</option>';
echo '<option value="csv" selected>'.'CSV'.'</option>';
echo '</select>';
echo ' ';
echo 'Destination'.' ';
echo '<select name="put">';
echo '<option value="dload" selected>'.'Download'.'</option>';
echo '<option value="browser">'.'Browser'.'</option>';
echo '</select>';
echo '<input type="hidden" name="action" value="'.'export'.'" />';
echo ' ';
echo '<input type="submit" value="'.'Export'.'" />';
echo '</form>';
}

?>