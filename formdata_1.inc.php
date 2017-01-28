<? if (!defined('IN_ENGINE')) {die('forbidden');}

echo '<form name="console" id="console" action="'.$_SERVER['PHP_SELF'].'" method="post">';
echo '<table border="0" cellspacing="3" cellpadding="3">';

$cfk='starr'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Fav'.shw_mandat($cfk,1).'</td><td>';
echo '<input type="checkbox" name="'.$cfk.'" value="1" ';
if ($dbi[$cfk]) {echo 'checked ';}
echo shw_mandat($cfk,2).'/>';
echo '</td></tr>';
}

$cfk='name'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Name'.shw_mandat($cfk,1).'</td><td>'.'<input type="text" name="'.$cfk.'" value="'.htmlinputval($dbi[$cfk]).'" '.maxlenprofp($dbdatlen[$cfk]).' '.shw_mandat($cfk,2).'/>'.'</td></tr>';
}

$cfk='lname'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Last Name'.shw_mandat($cfk,1).'</td><td>'.'<input type="text" name="'.$cfk.'" value="'.htmlinputval($dbi[$cfk]).'" '.maxlenprofp($dbdatlen[$cfk]).' '.shw_mandat($cfk,2).'/>'.'</td></tr>';
}

$cfk='gend'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Gender'.shw_mandat($cfk,1).'</td><td>';
echo '<input type="radio" name="gend" value="0" ';
if (!$dbi[$cfk]) {echo 'checked ';}
echo shw_mandat($cfk,2).'/>'.'Unspecified'.',';
echo '<input type="radio" name="gend" value="1" ';
if ($dbi[$cfk]==1) {echo 'checked ';}
echo shw_mandat($cfk,2).'/>'.'Male'.',';
echo '<input type="radio" name="gend" value="2" ';
if ($dbi[$cfk]==2) {echo 'checked ';}
echo shw_mandat($cfk,2).'/>'.'Female'.',';
echo '</td></tr>';
}

$cfk='bday'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Birthday'.' '.'(day / month / year)'.shw_mandat($cfk,1).'</td><td>';
echo '<select name="bdayd"'.shw_mandat($cfk,2).'>';
echo '<option value="'.'0'.'">-</option>';
for ($i=1;$i<=31;$i++) {
echo '<option ';
if ($i == $dbi['bdayd']) {echo 'selected ';}
echo 'value="'.$i.'">'.$i.'</option>';
}
echo '</select>';
echo ' / ';
echo '<select name="bdaym"'.shw_mandat($cfk,2).'>';
echo '<option value="'.'0'.'">-</option>';
for ($i=1;$i<=12;$i++) {
echo '<option ';
if ($i == $dbi['bdaym']) {echo 'selected ';}
# echo 'value="'.$i.'">'.date('M',mktime(0,0,0,$i,1,98)).'</option>';
echo 'value="'.$i.'">(';
if ($i<10) {echo ' ';}
echo $i.') ';
# echo $es_mth[$i-1];
echo '</option>';
}
echo '</select>';
echo ' / ';
echo '<input type="text" size="6" maxlength="4" value="'.htmlinputval($dbi['bdayy']).'" name="bdayy" '.shw_mandat($cfk,2).'/>';
echo '</td></tr>';
}

$cfk='address'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Address'.shw_mandat($cfk,1).'</td><td>'.'<input type="text" name="'.$cfk.'" value="'.htmlinputval($dbi[$cfk]).'" '.maxlenprofp($dbdatlen[$cfk]).' '.shw_mandat($cfk,2).'/>'.'</td></tr>';
}

$cfk='phonecell'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Mobile Phone'.shw_mandat($cfk,1).'</td><td>'.'<input type="phone" name="'.$cfk.'" value="'.htmlinputval($dbi[$cfk]).'" '.maxlenprofp($dbdatlen[$cfk]).' '.shw_mandat($cfk,2).'/>'.'</td></tr>';
}

$cfk='email'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'E-mail'.shw_mandat($cfk,1).'</td><td>'.'<input type="email" name="'.$cfk.'" value="'.htmlinputval($dbi[$cfk]).'" '.maxlenprofp($dbdatlen[$cfk]).' '.shw_mandat($cfk,2).'/>'.'</td></tr>';
}

$cfk='www'; if (auth_dbdat($cfk,$dbdat)) {
echo '<tr><td>'.'Web Site'.shw_mandat($cfk,1).'</td><td>'.'<input type="url" name="'.$cfk.'" value="'.htmlinputval($dbi[$cfk]).'" '.maxlenprofp($dbdatlen[$cfk]).' '.shw_mandat($cfk,2).'/>'.'</td></tr>';
}

echo '</table>';
echo '<input type="hidden" name="id" value="'.$id.'" />';
echo '<input type="hidden" name="action" value="'.$action.'" />';
echo '<input type="hidden" name="xgo" value="1" />';
echo '<input type="submit" value="';
if ($action=='add') {echo 'Add';} else {echo 'Update';}
echo '" />';
echo '</form>';

?>