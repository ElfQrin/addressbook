<? if (!defined('IN_ENGINE')) {die('forbidden');}

# Output Footer
switch ($outfmt) {
case 'webpage':
case 'webpage_list':
echx($fwhandle,'</table>');
break;
case 'xml':
echx($fwhandle,"</xml>");
break;
case 'json':
echx($fwhandle,"}");
break;
}

?>