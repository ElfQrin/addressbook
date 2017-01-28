<? if (!defined('IN_ENGINE')) {die('forbidden');}

# Output Body
switch ($outfmt) {
default:

## Inner Header
switch ($outfmt) {
case 'webpage':
if ($cp>1) {echx($fwhandle,'<tr><td colspan="0">&nbsp;</td></tr>');}
break;
case 'webpage_list':
echx($fwhandle,"<tr>");
break;
case 'xml':
echx($fwhandle,"<contact>\n");
break;
case 'json':
if ($cp>1) {echx($fwhandle,",\n");}
echx($fwhandle,"{\n");
break;
}

$xnel=0;
## Inner Body
if ($shwctrls && auth_user('DELM,FAVM','|')) {
$cfk='id';
echo fmtcheckbox($outfmt,$dbey[$cfk]);
# fmtoitem($outfmt,'ID',$dbey[$cfk]));
}

# $cfk='id'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'ID',$dbey[$cfk]));} }
$cfk='starr'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Fav',$dbey[$cfk]));} }
$cfk='name'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Name',$dbey[$cfk]));} }
$cfk='lname'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Last Name',$dbey[$cfk]));} }
$cfk='gend'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) {
switch ($dbey[$cfk]) {
case 1:
$vt='Male';
break;
case 2:
$vt='Female';
break;
default:
$vt='Unspecified';
break;
}
if ($vt || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Gender',$vt));}
}
$cfk='bday'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) {
$vt=dateread($dbey[$cfk]); if ($vt || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Birthday',$vt));}
}
$cfk='address'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Address',$dbey[$cfk]));} }
$cfk='phonecell'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Mobile Phone',$dbey[$cfk]));} }
$cfk='email'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) {
$vt=shwemail($dbey[$cfk],$user_email); if ($vt || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'E-mail',$vt));}
}
$cfk='www'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { if ($dbey[$cfk] || $showeft) {$xnel++; echx($fwhandle,fmtoitem($outfmt,'Web site',$dbey[$cfk]));} }

## Inner Footer
switch ($outfmt) {
case 'webpage_list':
echx($fwhandle,"</tr>");
break;
case 'txt':
case 'html':
case 'csv':
echx($fwhandle,"\n");
break;
case 'xml':
echx($fwhandle,"</contact>\n");
break;
case 'json':
echx($fwhandle,"}\n");
break;
}

break;

# Output formats which require special handling
case 'raw':
echx($fwhandle,'# '.$cp.'. ');
$rlen=count($dbey);
for ($i=0;$i<=$rlen-1;$i++) {
// echx($fwhandle,'');
echx($fwhandle,'"'.addslashes($dbey[$i]).'"');
if ($i<$rlen) {echx($fwhandle,', ');}
}
echx($fwhandle,"\n");
break;
}

?>