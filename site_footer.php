<? if (!defined('IN_ENGINE')) {die('forbidden');} ?>

<br /><br />
<center>
<?
# echo '<a href="'.$edge_main_url.$_SERVER['REQUEST_URI'].'">'.flecho('permalink', $es_plink); echo '</a>'.'<br>';
# echo 'powered by<br><a href="http://labs.geody.com/dagger/" target="_blank"><i>dagger - the cutting edge</i></a><br>';
echo '<p><a href="'.$edge_main_url.'legal.php">'.'Legal notices: copyright, privacy policy, disclaimer'.'</a>';
?>
</center>
<?
# echo "<p><script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n".'document.writeln(\'<a href="javascript:history.go(-1);">'.flecho('Go back',$es_back).'</a><br>\');'."\n"."// -->\n</script>\n"; # Go back to previous page in history, not recommended because it doesn't work if someone opened the link in a new page or a new tab, or it can return to an external website if the page was opened from a link from another website (like a search engine), both cases are likely to annoy visitors.
# echo "<p><script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n".'document.writeln(\'<a href="javascript:document.location.reload();">'.'Refresh this page'.'</a><br>\');'."\n"."// -->\n</script>\n"; # Refresh current page using a link
# echo "<p><script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n".'document.writeln(\'<input type="button" value="Refresh this page" onClick="document.location.reload();">'.'<br>\');'."\n"."// -->\n</script>\n"; # Refresh current page using a button
# '</center><br>';
# echo '<br><center>'.'<a href="#top">'.'go to the top of the page'.'</a></center><br>';
# echo '</td>','</tr></table>','</center>';
# echo "\n<SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\">\n<!--\nself.focus();\n// -->\n</SCRIPT>\n";	# bring window to front
?>

<a name="bottom"></a>
</body>
</html>
<? dbx_close($dbx,$dbxcon); ?>