<? if (!defined('IN_ENGINE')) {die('forbidden');}

# Output Header
switch ($outfmt) {
case 'webpage':
echx($fwhandle,'<table border="0" cellpadding="3" cellspacing="3">');
break;
case 'webpage_list':
echx($fwhandle,'<table border="0" cellpadding="3" cellspacing="3">');
echx($fwhandle,'<tr>');
if ($shwctrls) { echo '<td>'.''.'</td>'; }
$cfk='name'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Name'.'</td>'); }
$cfk='lname'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Last Name'.'</td>'); }
$cfk='gend'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Gender'.'</td>'); }
$cfk='bday'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Birthday'.'</td>'); }
$cfk='address'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Address'.'</td>'); }
$cfk='phonecell'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Mobile Phone'.'</td>'); }
$cfk='email'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'E-mail'.'</td>'); }
$cfk='www'; if (auth_usrvwx($cfk,$dbdat) && (!$useminimitems || ($useminimitems && in_array($cfk,$minimitems)))) { echx($fwhandle,'<td>'.'Website'.'</td>'); }
echx($fwhandle,'</tr>');
break;
case 'xml':
echx($fwhandle,"<xml>\n");
break;
case 'json':
echx($fwhandle,"{\n");
break;
}

?>