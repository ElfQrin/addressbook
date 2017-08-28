<?
include_once('functions_db.php');

/*
function import_globals() {
	global $HTTP_SERVER_VARS;
	global $REMOTE_ADDR, $PHP_SELF;

	# register_globals turned off?
	$_igr = ini_get('register_globals');
	# if ($_igr == '' || $_igr == 'Off' || $_igr == 0) {import_request_variables('GPC');} # This function has been DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0.

	# other misc server vars needed
	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	# if ($_SERVER['HTTP_X_FORWARDED_FOR']!='') { $REMOTE_ADDR=$_SERVER['HTTP_X_FORWARDED_FOR']; } # get real IP address from proxies, when possible (on the other hand, this could return LAN IPs)
	$PHP_SELF = $_SERVER['PHP_SELF'];
}
*/

# registers variable, if no type is given, it'll try GPC
function regvar($variable,$type) {
	if ($type == 'g' || !$type)
		$_v = $_GET[$variable];
	elseif ($type == 'p' || (!$type && !$_v))
		$_v = $_POST[$variable];
	elseif ($type == 'c' || (!$type && !$_v))
		$_v = $_COOKIE[$variable];
	return($_v);	
}

function codetext($text) {
	$text = str_replace('	',"&nbsp;&nbsp;&nbsp;&nbsp;",$text);
	$text = str_replace('    ',"&nbsp;&nbsp;&nbsp;&nbsp;",$text);
	return $text;
}

function authdenied($action='') {
	global $es_accessdenied;
	# echo '<p class="edgebig">';
	switch($action) {
		default:
		lecho('access denied',$es_accessdenied);
		break;
	}
	# echo '</p>';
}

function flecho($orig_text,$trans_text='') {
global $dir_skin;
if ($trans_text) {
$a=$trans_text;
} else {
$a=$orig_text;
}
# it should optionally allow ALT description, something like '[img]|example.jpg|this is an example' or '[img]|example.jpg'
if (strtolower(substr($a,0,5)=='[img]')) {
$b=explode('|',$a);
$a='<img src="'.$dir_skin.$b[1].'" border="0" alt="'.$b[2].'" title="'.$b[3].'">';
}
return $a;
}

function lecho($orig_text,$trans_text) {
global $dir_skin;
$a=flecho($orig_text,$trans_text);
echo $a;
}

function incviewed($newsid) {
	global $dbx, $dbxcon, $edge_database, $edge_database_auth;
	global $edge_id, $edge_logged;
	global $edge_incviewsunreg;

	$t = time();

	if ($newsid) {
		if ($edge_incviewsunreg || ($edge_id && $edge_logged)) {
			$_q = "UPDATE news SET viewed = viewed + 1 WHERE id = '$newsid'";
			dbx_query($dbx,$dbxcon,$_q,$edge_database);
		}

		if ($edge_id && $edge_logged) {
			$_q = "SELECT lastviewed FROM people WHERE id = $edge_id";
			$_r = dbx_query($dbx,$dbxcon,$_q,$edge_database_auth);
			$_row = dbx_fetch_object($dbx,$_r);

			if ($t > $_row->lastviewed + 60*5) {
		                $_q = "UPDATE people SET lastviewed = $t WHERE id = $edge_id";
		                dbx_query($dbx,$dbxcon,$_q,$edge_database_auth);
			}
	        }
	}
}

/*
function dbx_check() {
global $dbx,$dbxcon;
if (!dbx_server_info($dbx,$dbxcon)) {die('No DB');}
}
*/

function myaddslashes($st) {
	if (get_magic_quotes_gpc())
		return $st;
	else
		return addslashes($st);
}

# type validity check functions written by caboom <caboom@box.sk>, fixed by Cube, fixed by ElfQrin
function checkint($x,$f='') {
if ($x===0) {return (0);}
if ($x != '') {
if (preg_match('/^-?\d+$/',$x)) {return($x);}
}
return($f);
}

function checkstr($x) {
	$m = array("%","+");
	$x = myaddslashes($x);
	foreach($m as $mkay)
		$x = str_replace($mkay, "\\" . $mkay, $x);
	return ($x);
}

function is_auth_valid_char($x) {
global $edge_multibyte;
if ($edge_multibyte) {return(1);}	# bad hack, need to check for proper characters for particular charset
if (eregi("^[_\\.^0-9a-z-]+$",$x)) {return(1);} else {return(0);}	# allowed characters: 0-9, a-z, A-Z, _ . ^ -
}

function auth_validname($x) {
global $edge_multibyte;
if ($x == '?') {return(1);}
if ($edge_multibyte) {return(1);}	# bad hack, need to check for proper characters for particular charset
if (eregi("^[_\\.^0-9a-z-]+$",$x)) {return(1);} else {return(0);}	# allowed characters: 0-9, a-z, A-Z, _ . ^ -
}

# specific for travel.box.sk and other sites, currently, just being kept here for compatibility
function foto($foto) {
        $size = GetImageSize("$foto");
        return "'javascript:otvor(\"$foto\",$size[0],$size[1])'";
}


function do_smileys($msgtxt) {
global $dir_smileys;
	# this code has been crafted by Carl - carl@smmb.org ; new smileys (emoticons) added by Elf Qrin (www.ElfQrin.com)

	$msgtxt = str_replace(":pimp", "<img src=\"".$dir_smileys."boss.gif\">", "$msgtxt");
	$msgtxt = str_replace(":boss", "<img src=\"".$dir_smileys."boss.gif\">", "$msgtxt");

	$msgtxt = ereg_replace("^:\(([[:space:]]*)", "<img src=\"".$dir_smileys."angry.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("^:-\(([[:space:]]*)", "<img src=\"".$dir_smileys."angry.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("^:P([[:space:]]*)", "<img src=\"".$dir_smileys."tongue.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("^:p([[:space:]]*)", "<img src=\"".$dir_smileys."tongue.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("^:D([[:space:]]*)", "<img src=\"".$dir_smileys."grin.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("^:\)([[:space:]]*)", "<img src=\"".$dir_smileys."smile.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("^:-\)([[:space:]]*)", "<img src=\"".$dir_smileys."smile.gif\">\\1", "$msgtxt");

	$msgtxt = ereg_replace("([[:space:]]):\($", "<img src=\"".$dir_smileys."angry.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):-\($", "<img src=\"".$dir_smileys."angry.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):P$", "<img src=\"".$dir_smileys."tongue.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):p$", "<img src=\"".$dir_smileys."tongue.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):D$", "<img src=\"".$dir_smileys."grin.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):\)$", "<img src=\"".$dir_smileys."smile.gif\">\\1", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):-\)$", "<img src=\"".$dir_smileys."smile.gif\">\\1", "$msgtxt");

	$msgtxt = ereg_replace("([[:space:]]):P([[:space:]])", "\\1<img src=\"".$dir_smileys."tongue.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):p([[:space:]])", "\\1<img src=\"".$dir_smileys."tongue.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):\)([[:space:]])", "\\1<img src=\"".$dir_smileys."smile.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):\(([[:space:]])", "\\1<img src=\"".$dir_smileys."angry.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):-\)([[:space:]])", "\\1<img src=\"".$dir_smileys."smile.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):-\(([[:space:]])", "\\1<img src=\"".$dir_smileys."angry.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]);\)([[:space:]])", "\\1<img src=\"".$dir_smileys."wink.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]);-\)([[:space:]])", "\\1<img src=\"".$dir_smileys."wink.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]])8-\)([[:space:]])", "\\1<img src=\"".$dir_smileys."cool.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]])8\)([[:space:]])", "\\1<img src=\"".$dir_smileys."cool.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]])R-\)([[:space:]])", "\\1<img src=\"".$dir_smileys."rolleyes.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]])R\)([[:space:]])", "\\1<img src=\"".$dir_smileys."rolleyes.gif\">\\2", "$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):D([[:space:]])", "\\1<img src=\"".$dir_smileys."grin.gif\">\\2","$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]):-D([[:space:]])", "\\1<img src=\"".$dir_smileys."grin.gif\">\\2","$msgtxt");
	$msgtxt = ereg_replace("([[:space:]]);D([[:space:]])", "\\1<img src=\"".$dir_smileys."grin.gif\">\\2","$msgtxt");

	$msgtxt = str_replace(":argh", "<img src=\"".$dir_smileys."argh.gif\">", "$msgtxt");
	$msgtxt = str_replace(":banghead", "<img src=\"".$dir_smileys."banghead.gif\">", "$msgtxt");
	$msgtxt = str_replace(":beamup", "<img src=\"".$dir_smileys."beamup.gif\">", "$msgtxt");
	$msgtxt = str_replace(":blowup", "<img src=\"".$dir_smileys."blowup.gif\">", "$msgtxt");
	$msgtxt = str_replace(":bow", "<img src=\"".$dir_smileys."bow.gif\">", "$msgtxt");
	$msgtxt = str_replace(":flameon", "<img src=\"".$dir_smileys."flameon.gif\">", "$msgtxt");
	$msgtxt = str_replace(":flamer", "<img src=\"".$dir_smileys."flamer.gif\">", "$msgtxt");
	$msgtxt = str_replace(":flowers", "<img src=\"".$dir_smileys."flowers.gif\">", "$msgtxt");
	$msgtxt = str_replace(":hug", "<img src=\"".$dir_smileys."hug.gif\">", "$msgtxt");
	$msgtxt = str_replace(":kick", "<img src=\"".$dir_smileys."kick.gif\">", "$msgtxt");
	$msgtxt = str_replace(":ninja", "<img src=\"".$dir_smileys."ninja.gif\">", "$msgtxt");
	$msgtxt = str_replace(":onthecan", "<img src=\"".$dir_smileys."onthecan.gif\">", "$msgtxt");
	$msgtxt = str_replace(":stick", "<img src=\"".$dir_smileys."stick.gif\">", "$msgtxt");
	$msgtxt = str_replace(":rotfl", "<img src=\"".$dir_smileys."rotfl.gif\">", "$msgtxt");
	$msgtxt = str_replace(":shakehands", "<img src=\"".$dir_smileys."shakehands.gif\">", "$msgtxt");
	$msgtxt = str_replace(":surrender", "<img src=\"".$dir_smileys."surrender.gif\">", "$msgtxt");
	$msgtxt = str_replace(":thankyou", "<img src=\"".$dir_smileys."thankyou.gif\">", "$msgtxt");
	$msgtxt = str_replace(":thewave", "<img src=\"".$dir_smileys."thewave.gif\">", "$msgtxt");
	$msgtxt = str_replace(":wave", "<img src=\"".$dir_smileys."wave.gif\">", "$msgtxt");
	$msgtxt = str_replace(":withstupid", "<img src=\"".$dir_smileys."withstupid.gif\">", "$msgtxt");
	$msgtxt = str_replace(":yawn", "<img src=\"".$dir_smileys."yawn.gif\">", "$msgtxt");
	$msgtxt = str_replace(":buzzer", "<img src=\"".$dir_smileys."buzzer.gif\">", "$msgtxt");
	$msgtxt = str_replace(":chuckball", "<img src=\"".$dir_smileys."chuckball.gif\">", "$msgtxt");
	$msgtxt = str_replace(":claphands", "<img src=\"".$dir_smileys."claphands.gif\">", "$msgtxt");
	$msgtxt = str_replace(":dj", "<img src=\"".$dir_smileys."dj.gif\">", "$msgtxt");
	$msgtxt = str_replace(":dropjaw", "<img src=\"".$dir_smileys."dropjaw.gif\">", "$msgtxt");

# added by Joris
	$msgtxt = str_replace(":haha", "<img src=\"".$dir_smileys."laugh.gif\">","$msgtxt");
	$msgtxt = str_replace(":nono", "<img src=\"".$dir_smileys."nono.gif\">","$msgtxt");
	$msgtxt = str_replace(":wave", "<img src=\"".$dir_smileys."wave2.gif\">","$msgtxt");
	$msgtxt = str_replace("???", "<img src=\"".$dir_smileys."confused.gif\">","$msgtxt");
	$msgtxt = str_replace(':-S', "<img src=\"".$dir_smileys."perplex.gif\">","$msgtxt");
	$msgtxt = str_replace(":tup", "<img src=\"".$dir_smileys."thumbsup.gif\">","$msgtxt");
	$msgtxt = str_replace(":tdown", "<img src=\"".$dir_smileys."thumbsdown.gif\">","$msgtxt");
	$msgtxt = str_replace(":grr", "<img src=\"".$dir_smileys."grr.gif\">","$msgtxt");
	$msgtxt = str_replace(':-|', "<img src=\"".$dir_smileys."indifferent.gif\">","$msgtxt");
	$msgtxt = str_replace(':|', "<img src=\"".$dir_smileys."indifferent.gif\">","$msgtxt");

# added by ElfQrin (22oct2003)
	$msgtxt = str_replace('8O', "<img src=\"".$dir_smileys."omg.gif\">","$msgtxt");
	$msgtxt = str_replace('8-O', "<img src=\"".$dir_smileys."omg.gif\">","$msgtxt");
	$msgtxt = str_replace(':-\\', "<img src=\"".$dir_smileys."undecided.gif\">","$msgtxt");
	$msgtxt = str_replace(':-/', "<img src=\"".$dir_smileys."skeptical.gif\">","$msgtxt");
	$msgtxt = str_replace(":bounce", "<img src=\"".$dir_smileys."bounce.gif\">", "$msgtxt");
	$msgtxt = str_replace(":chat", "<img src=\"".$dir_smileys."chatter.gif\">", "$msgtxt");
	$msgtxt = str_replace(":coffeine", "<img src=\"".$dir_smileys."coffeine.gif\">", "$msgtxt");
	$msgtxt = str_replace(":embarassed", "<img src=\"".$dir_smileys."embarassed.gif\">", "$msgtxt");
	$msgtxt = str_replace(":evil", "<img src=\"".$dir_smileys."evil.gif\">", "$msgtxt");
	$msgtxt = str_replace(":eviltwist", "<img src=\"".$dir_smileys."evil-twisted.gif\">", "$msgtxt");
	$msgtxt = str_replace(":scary", "<img src=\"".$dir_smileys."scary.gif\">", "$msgtxt");
	$msgtxt = str_replace(":zzz", "<img src=\"".$dir_smileys."sleeping.gif\">", "$msgtxt");
	$msgtxt = str_replace(":shot", "<img src=\"".$dir_smileys."smiley_rifle-shot.gif\">", "$msgtxt");
	$msgtxt = str_replace(":spineyes", "<img src=\"".$dir_smileys."spineyes.gif\">", "$msgtxt");
	$msgtxt = str_replace(" S-|", "<img src=\"".$dir_smileys."spineyes.gif\">", "$msgtxt");

# added by ElfQrin (20jun2004)
	$msgtxt = str_replace(':cop', "<img src=\"".$dir_smileys."smilecop.gif\">","$msgtxt");
	$msgtxt = str_replace(':king', "<img src=\"".$dir_smileys."king.gif\">","$msgtxt");
	$msgtxt = str_replace(':read', "<img src=\"".$dir_smileys."read.gif\">","$msgtxt");
	$msgtxt = str_replace(':type', "<img src=\"".$dir_smileys."typecomp.gif\">","$msgtxt");

# added by ElfQrin (01mar2008)
	$msgtxt = ereg_replace("([[:space:]]):s([[:space:]])", "\\1<img src=\"".$dir_smileys."disappointed.gif\">\\2","$msgtxt");
	$msgtxt = str_replace(':bloo', "<img src=\"".$dir_smileys."blush.gif\">","$msgtxt");

	return($msgtxt);
}

function safeXSS(&$text) {
	$text = strip_tags($text, '<b><i><br>');
}

function safeHTML($text,$smiles=TRUE) {
	global $edge_smileys;
	$text = strip_tags($text, '<b><i><u><sub><sup><a><img><table><tr><td><th><br><p><font><code>');
	if ($edge_smileys && $smiles) $text = do_smileys($text);
	return $text;
}

function safeHTMLboard($text,$smiles=TRUE) {
	global $edge_smileys;
	$text = strip_tags($text, '<b><i><u><sub><sup><table><tr><td><th><br><p><code>');
	if ($edge_smileys && $smiles) $text = do_smileys($text);
	return $text;
}

function buildHypertext($text) {
#	return $text;
	$parts = explode('<br />', $text);
	for($i = 0; $i < sizeof($parts); $i++)
		$parts[$i] = buildHyperlinks($parts[$i]);
	$_r = join('<br />', $parts);
	return $_r;
}

# Linkify URLs
# many thanks to Aztek, aztek@box.sk for supplying this neat function
# RegExps updated by ElfQrin
function buildHyperlinks($string) {
	$httpurl = "(^((f|ht){1}tp(s){0,1}://)[-\/a-zA-Z0-9/@:%_.~#\?&;=]+[\/a-zA-Z0-9@:%_~#\?&;=])";
#	$wwwsurl = "(www[.][a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&]))";
	$mailurl = "([_\\.0-9a-z-]+@([_\\.0-9a-z-]+)+[a-z]{2,4})";

	$parts   = split("[[:space:]]", $string);
#	$parts	 = explode(' ', $string);
	for($i = 0; $i < sizeof($parts); $i++) {
		if(eregi($httpurl, $parts[$i])) {
			$temp       = $parts[$i];
			$parts[$i]  = eregi_replace($httpurl, "<a href=\"".$edge_main_url."redirect.php?\\1\" target=\"_blank\">", $parts[$i]);
			$parts[$i] .= "$temp</a>";
		}

#		if(eregi($wwwsurl, $parts[$i])) {
#			$temp       = $parts[$i];
#			$parts[$i]  = eregi_replace($wwwsurl, "\\2<a href=\"".$edge_main_url."redirect.php?http://\\3\" target=\"_blank\">", $parts[$i]);
#			$parts[$i] .= "$temp</a>";
#		}

		if(eregi($mailurl, $parts[$i])) {
			$temp       = $parts[$i];
			$parts[$i]  = eregi_replace($mailurl, "<a href=\"mailto:\\1\">", $parts[$i]);
			$parts[$i] .= "$temp</a>";
		}
	}
	return join(' ', $parts);
}

function pw_enc($w,$pwd,$enctyp) {
switch ($enctyp) {
case 1:
# XOR
$a=xor_string($w,$pwd);
break;
case 2:
# mcrypt
$a=des_encode($w);
break;
case 3:
# blowfish
$a=base64_encode(PMA_blowfish_encrypt($w,$pwd));
break;
default:
case 0:
# plain text
$a=$w;
break;
}
return $a;
}

function pw_dec($w,$pwd,$enctyp) {
switch ($enctyp) {
case 1:
# XOR
$a=xor_string($w,$pwd);
break;
case 2:
# mcrypt
$a=des_decode($w);
break;
case 3:
# blowfish
$a=PMA_blowfish_decrypt(base64_decode($w),$pwd);
break;
default:
case 0:
# plain text
$a=$w;
break;
}
return $a;
}

function cryptp($v1,$v2=null) {
global $forcenc;
switch ($forcenc) {
case 0:	# standard (DES)
$a=crypt($v1,$v2);
break;
case 1:	# MD5
$a=crypt_md5($v1,$v2);
break;
}
return $a;
}

# from PHP man, by mimec at wp dot pl r26-Jun-2003-09:40
function crypt_md5($str, $salt=null) {
  if (!$salt) {$salt=md5(uniqid(rand(),1));}
  $salt=substr($salt, 0, 8);
  return $salt.':'.md5($salt.$str);
}

# returns correct protection hashed value to be filled into the form
function prot() {
	global $edge_hashedpassword;
	global $edge_mcrypt_password;
	return (cryptp($edge_hashedpassword.$edge_prot_password));
}

# checks if proper protection hashed value was sent by form
function chprot($prot) {
	global $edge_hashedpassword;
	global $edge_mcrypt_password;
	if ($prot == cryptp($edge_hashedpassword.$edge_prot_password,$prot))
		return 1;
	return 0;
}

# checks HTTP_REFERER against $edge_main_url
function chref() {
	global $edge_main_url, $edge_httprefcheck;

	if ($edge_httprefcheck) {
		$r = $_SERVER['HTTP_REFERER'];
		if (substr($r,0,strlen($edge_main_url)) == $edge_main_url) {
		return 1;
		} else {
		if ($r=='') {
			echo 'fatal error: no HTTP_REFERER, make sure your browser sends HTTP_REFERER correctly<p>';
			return 0;
			} else {
			echo 'fatal error: bad HTTP_REFERER<p>';
			return 0;
			}
		}
	}
	return 1;
}

function codetag($txt, $typ='') {
	global $edge_codetagcolors_off;

	$r = '';

	if (strpos($txt,'[code]') === FALSE) {
		switch ($typ) {
		case 'board':
		case 'blog':
		return(buildHypertext(safeHTMLboard($txt)));
		break;
		case 'art':
		case 'artprt':
		case 'arttom':
		return(buildHypertext($txt));
		break;
		default:
		case '':
		case 'sms':
		return(buildHypertext(safeHTML($txt)));
		break;
	}
	}

	$e = explode('[code]',$txt);

	if ($edge_smileys) {do_smileys($e[0]);}	# smileys hack by Carl

		switch ($typ) {
		case 'board':
		case 'blog':
		$r.=buildHypertext(safeHTMLboard($e[0]));
		break;
		case 'art':
		case 'artprt':
		case 'arttom':
		$r.=buildHypertext($e[0]);
		break;
		default:
		case '':
		case 'sms':
		$r.=buildHypertext(safeHTML($e[0]));
		break;
	}

	for ($i = 1; $i<sizeof($e); $i++) {
		$s = $e[$i];

		$_rest = '';
		$pos = strpos($s,'[/code]');
		if ($pos != FALSE) {
			$_code = substr($s,0,$pos);
			$_rest = substr($s,$pos+7); 
		} else {$_code = $s;}

		$_code = preg_replace("/(\r\n|\n|\r)/", "\n", $_code);
		$_code = preg_replace("/\n\n+/", "\n\n", $_code); 
		$_code = preg_replace("/\<br \/\>\n/", "\n", $_code); 

		$_code = '<'.'?'.$_code.'?'.'>';

		ob_start();
		highlight_string($_code);
		$_r = ob_get_contents();
		ob_end_clean();
		$p1 = strpos ($_r,"&lt;?");
		$p2 = strrpos ($_r,"?&gt;"); 
		$_r = substr($_r, 0, $p1).substr($_r, $p1+5, $p2-($p1+5)).substr($_r, $p2+5); 

		if ($edge_codetagcolors_off) {
			$_r = preg_replace('/<font color=\"\#[\d\w]+\">/','',$_r);
			$_r = preg_replace('/\<\/font\>/','',$_r);
		}
		$r .= $_r;

		switch ($typ) {
		case 'board':
		case 'blog':
		$r.=buildHypertext(safeHTMLboard($_rest));
		break;
		case 'art':
		case 'artprt':
		case 'arttom':
		$r.=buildHypertext($_rest);
		break;
		default:
		case '':
		case 'sms':
		$r.=buildHypertext(safeHTML($_rest));
		break;
	}

	}
	return($r);
}

function dispcomments($id,$short=false) {
	global $edge_database, $dbxcon, $edge_main_url, $es_recentcom;

	$q = "SELECT thread,id,dat,subj,meno FROM wb WHERE did = 'edge$id' AND thread = 0 AND hide = 0 ORDER BY dat DESC LIMIT 0,6";
	$result = dbx_query($dbx,$dbxcon,$q,$edge_database);
	$c = dbx_num_rows($dbx,$result);

	if ($c > 0) {
		echo "<p><span class=\"edgemenu\">".flecho('recent comments',$es_recentcom).":</span><br>";
		$i = 0;
		echo '<table cellspacing="0" cellpadding="1" border="0">';
		while (($o=dbx_fetch_object($dbx,$result)) && $i<5) {
			echo "<tr><td valign=\"top\" class=\"edgeadate\"><a href=\"".$edge_main_url."board.php?thread=$o->id&did=".rawurlencode("edge$id")."&disp=$o->id\">".$o->subj."</a></td>";  # htmlentities_mb($o->subj) is not needed because forum message subjects are already rawurlencoded
			if (!$short) {
				echo "<td width=\"20%\" align=\"left\" valign=\"top\" class=\"edgeadate\"> - <a href=\"".$edge_main_url."user.php?name=".rawurlencode($o->meno)."\">$o->meno</a></td>";
				echo "<td valign=\"top\" align=\"right\" class=\"edgeadate\">".date_tz("d M Y H:i",$o->dat)."</td>";
			}
			echo "</tr>";
			$i++;
		}
		echo '</table>';
		if ($c > 5) {echo "<a href=\"".$edge_main_url."board.php?did=".rawurlencode("edge$id")."\">...</a>";}
		if (!$short) {echo '<p>';}
	}
}

function htmlspecialchars_mb($x) {
global $edge_multibyte, $edge_charset;
if ($edge_multibyte) {
return(htmlspecialchars($x,ENT_COMPAT,$edge_charset));
} else {
return(htmlspecialchars($x));
}
}

function htmlentities_mb($x) {
	global $edge_multibyte;

	if ($edge_multibyte)
		return($x);	# just a quick hack, will code proper routine later
	else
		return(htmlentities($x));
}

function show_flag($user) {
	global $dbx, $dbxcon, $edge_database_auth;
	global $edge_countryflags, $edge_main_url, $dir_inc, $dir_cflags;

    if ($edge_countryflags) {
	$q = "SELECT ccode,COUNT(*) AS c FROM people_lastlogged WHERE login = '$user' ";
	if ($r = dbx_query($dbx,$dbxcon,$q,$edge_database_auth))
		$o = dbx_fetch_object($dbx,$r);

	if ($o->c == 0) {
		$q = "SELECT ccode FROM people WHERE login = '$user' ";
		$r = dbx_query($dbx,$dbxcon,$q,$edge_database_auth);
		$o = dbx_fetch_object($dbx,$r);
	}
	$ccod=$o->ccode;
	switch ($edge_countryflags) {
	case 1:
	if ($ccod)
		if (file_exists($dir_inc.$dir_cflags.strtolower($ccod).'.gif')) {
		echo "<img src=\"".$edge_main_url.$dir_cflags.strtolower($ccod).".gif\" alt=\"".$ccod."\" title=\"".$ccod."\" border=\"0\"> ";
		} else {echo $ccod.' ';}
	else
		echo "<img src=\"".$edge_main_url.$dir_cflags."00.gif\" alt=\"?\" title=\"?\" border=\"0\"> ";
    break;
	case 2:
	default:
	if ($ccod)
		echo $ccod.' ';
	else
		echo '-- ';
	break;
}
} 
}

function show_gender($user) {
global $dbx, $dbxcon, $edge_database_auth;
global $edge_showgend, $edge_main_url, $dir_skin;
global $es_male, $es_female, $es_unspec;
if ($edge_showgend) {
$q = "SELECT gend FROM people WHERE login = '$user' ";
$r = dbx_query($dbx,$dbxcon,$q,$edge_database_auth);
$row_user = dbx_fetch_object($dbx,$r);

switch ($edge_showgend) {
case 1:
switch ($row_user->gend) {
case 1:
echo "<img src=\"".$edge_main_url.$dir_skin."gmale.png\" alt=\"".flecho('male',$es_male)."\" title=\"".flecho('male',$es_male)."\" border=\"0\"> ";
break;
case 2:
echo "<img src=\"".$edge_main_url.$dir_skin."gfemale.png\" alt=\"".flecho('female',$es_female)."\" title=\"".flecho('female',$es_female)."\" border=\"0\"> ";
break;
default:
echo "<img src=\"".$edge_main_url.$dir_skin."gunsp.png\" alt=\"".flecho('unspecified',$es_unspec)."\" title=\"".flecho('unspecified',$es_unspec)."\" border=\"0\"> ";
break;
}
break;
case 2:
default:
switch ($row_user->gend) {
case 1:
lecho('male',$es_male);
break;
case 2:
lecho('female',$es_female);
break;
default:
lecho('unspecified',$es_unspec);
break;
}
break;
}
}
}

function showuser($nick,$mask='&NK',$lnkprf=1,$lnktgt='',$gend=true,$cflg=true,$smem=true) {
global $edge_main_url, $dir_skin, $bar_linx, $edge_memo2;

if ($gend) {show_gender($nick);}
if ($cflg) {show_flag($nick);}

$lnkprf=checkint($lnkprf);
if ($lnkprf==1) {echo '<a href="'.$edge_main_url.'user.php?name='.rawurlencode($nick).'" '.$lnktgt.'>';}

# $mask format: &FN = First Name (name), &LN = Last Name (lname), &NK = Nick (login)
if ($mask!='&NK' && (strpos($mask,'&FN')!==false || strpos($mask,'&LN')!==false)) {
global $edge_database_auth,$dbxcon;

$q_user = "SELECT name,lname,email FROM people WHERE login = '$nick' ";
$result_user = dbx_query($dbx,$dbxcon,$q_user,$edge_database_auth);
$row_user = dbx_fetch_object($dbx,$result_user);
$mask=str_replace('&FN',htmlspecialchars_mb($row_user->name),$mask);
$mask=str_replace('&LN',htmlspecialchars_mb($row_user->lname),$mask);
}
$mask=str_replace('&NK',htmlspecialchars_mb($nick),$mask);

if (trim($mask)=='') {$mask=$nick;}
echo $mask;

if ($lnkprf>0) {echo '</a>';}

if ($smem && auth_privil($bar_linx,'UMM')) {
# echo " <a href=\"mailto:".htmlspecialchars($row_user->email)."?subject=[".$edge_main_url."]\">".'&lt;'.htmlspecialchars($row_user->email).'&gt;'."</a>";
if ($edge_memo2) {$_memo2='2';} else {$_memo2='';}
echo ' <a href="'.$edge_main_url.'memo'.$_memo2.'.send.php?to='.rawurlencode($nick).'" '.$lnktgt.'><img src="'.$edge_main_url.$dir_skin.'mail.gif" alt="" border="0"></a>';
}

if ($gend || $cflg || ($smem && auth_privil($bar_linx,'UMM'))) {
echo ' ';
}

}

function date_tz($formatstring,$dat) {
	global $edge_tz, $edge_servertz;

	if ($edge_tz=='' || $edge_tz==-1) {
		$edge_tz = (int)$_COOKIE['boxtz'];
	if ($edge_tz=='' || $edge_tz==-1) {$edge_tz=0;}
	}
	$datx = $dat - $edge_servertz*60*60 + $edge_tz*60*60/100;
# echo "<p>u: $edge_tz, s: $edge_servertz, f: $formatstring, d: $dat, dx: $datx<p>";
	return (date($formatstring,$datx));
}

function datetime_tz($dat) {
	global $edge_tz, $edge_servertz;

if ($dat) {
	$_e = (int)($edge_tz/100);
	$_f = abs($edge_tz/100 - $_e);
	if ($_f == 0) $_f = '';
	if ($_f == 0.5) $_f = ':30';
	if ($_f == 0.75) $_f = ':45';
	if ($_f == 0.25) $_f = ':15';
	if ($_e >= 0)
		$_e = "+$_e";
# $datx=date_tz("M d Y",$dat).' '.date_tz("H:i",$dat)." (UTC$_e$_f)";
$datx=date_tz("d M Y",$dat).' '.date_tz("H:i",$dat);
} else {
$datx='';
}
return $datx;
}

function fthumb($o) {
	$o = substr($o,4);
	if (substr($o,-4)=='.jpg' || substr($o,-4)=='.png') {
	$o = substr($o,0,strlen($o)-3).'jpg';
	}
	return $o;
}

# display a thumnbail for userpic or avatar
function thpic($nam,$clicky=0,$w=-1,$h=-1) {
	global $edge_main_url, $edge_uploaddir, $edge_uploadwww;

	$nam1 = substr($nam,4);
	if (substr($nam,-4)=='.jpg' || substr($nam,-4)=='.png') {
	$nam1 = substr($nam1,0,strlen($nam1)-3).'jpg';
	} else {
	$nam1 = $nam;
	}
	$_size = getimagesize($edge_uploaddir.'/'.$nam);
	if ($clicky)
		echo "<a href='javascript:otvor(\"".$edge_main_url."pic_th_disp.php?id=$nam\"," . ($_size[0]+14) .",". ($_size[1]+150) .")'>";
	if ($w!=-1) {$w1=' width="'.$w.'" ';}
	if ($h!=-1) {$h1=' heigth="'.$h.'" ';}
	echo "<img src=\"$edge_uploadwww/".$nam1."\"".$w1.$h1." border=\"0\">";
	if ($clicky)
		echo "</a>";
}

# deletes given uploaded image file with its thumbnail as well
function delupload($_realname,$typ=-1) {
	global $edge_database, $dbxcon;
	global $edge_uploaddir, $logthis, $edge_log;

	# we assume substr($_realname,0,4) == 'orig'
	$_realorigname = $_realname;
	$_realname = fthumb($_realname);

	$_un = $edge_uploaddir.'/'.$_realname;
	if (file_exists($_un)) {chmod ($_un, 0775); unlink($_un);}

	$_unorig = $edge_uploaddir.'/'.$_realorigname;
	if (file_exists($_unorig)) {chmod ($_unorig, 0775); unlink($_unorig);}

	$_qd = "DELETE FROM uploads WHERE realname = '$_realorigname'";
	$_resd = dbx_query($dbx,$dbxcon,$_qd,$edge_database);
if ($logthis['PIX']) {
switch ($typ) {
case 0:
case 1:
$_tn='article';
break;
case 2:
$_tn='blog';
break;
case 5:
$_tn='avatar';
break;
case 6:
$_tn='user';
break;
case 10:
case 11:
$_tn='gallery';
break;
}
logaction($edge_log,"picture (".$_tn.") del local_name=".$_realorigname." thumbnail_name=".$_realname."",$edge_log_freq);}
}

function auth_user($clearance,$m='&') {
global $edge_logged, $edge_privil;
$au=false; $cm=0;
if ($clearance=='') {$au=true;}
if (!$au && $edge_logged) {
$privileges=$edge_privil;
if ($privileges) {$_c='';} else {$_c=',';}
$lsclr=explode(',',$clearance); $lsprv=explode(',',$privileges);
$mxclr=sizeof($lsclr);
for ($i=0;$i<=$mxclr-1;$i++) {
$cclr=$lsclr[$i];
if (array_search($cclr,$lsprv,true) || $cclr==$lsprv[0]) {$cm++;}
}
if (($m=='&' && $cm==$mxclr) || ($m=='|' && $cm>0)) {$au=true;}
}
return($au);
}

function auth_privil($privil,$clearance,$m='&') {
$au=false; $cm=0;
if ($clearance=='') {$au=true;}
if (!$au) {
$privileges=$privil;
if ($privileges!='') {
$lsclr=explode(',',$clearance); $lsprv=explode(',',$privileges);
$mxclr=sizeof($lsclr);
for ($i=0;$i<=$mxclr-1;$i++) {
$cclr=$lsclr[$i];
if (array_search($cclr,$lsprv,true) || $cclr==$lsprv[0]) {$cm++;}
}
if (($m=='&' && $cm==$mxclr) || ($m=='|' && $cm>0)) {$au=true;}
}
}
return($au);
}

function add_items($list,$v,$s=',') {
if ($list!='') {
$ls2=explode($s,$v);
$mx2=sizeof($ls2);
for ($i=0;$i<=$mx2-1;$i++) {
if (!auth_privil($list,$ls2[$i])) {$list.=$s.$ls2[$i];}
}
} else {
$list=$v;
}
return $list;
}

function del_items($list,$v,$s=',') {
$ls1=explode($s,$list);
$ls2=explode($s,$v);
$mx2=sizeof($ls2);
for ($i=0;$i<=$mx2-1;$i++) {
$a=array_search($ls2[$i],$ls1,true);
if ($a || $a===0) {unset($ls1[$a]);}
}
$list=implode($s,$ls1);
return $list;
}

function getshwart($p,$subj,$w) {
$r='';
switch ($w) {
case false:
if ($p[$subj][1]) {
$r=$p[$subj][1];
} else {
$r=$p['xx'][1];
}
break;
case true:
if ($p[$subj][2]) {
$r=$p[$subj][2];
} else {
if ($p[$subj][1]) {
$r=$p[$subj][1];
} else {
$r=$p['xx'][2];
}
}
break;
}
return $r;
}

function counter($file='counterx',$show=false) {
global $dir_inc,$dir_logs,$edge_level,$edge_login;
if (auth_user('SU')) { # doesn't count level 8+ users
$file=str_replace('/','',$file);
$filea=$dir_inc.$dir_logs."counters/".$file;
if(!file_exists($filea) && is_writeable($dir_inc.$dir_logs.'counters/')){
$count=1;
$fh=fopen($filea,'w+');
fwrite($fh,$count);
} else {
if(!($fp=fopen($filea,'r'))) die ("Cannot open $filea.");
$count = (int) fread($fp,30);
fclose($fp);
$count++;
$fp=fopen($filea,'w+');
fwrite($fp, $count);
fclose($fp);
}
if ($show) {echo $count;}
}
}

function showcounter($file='counterx') {
global $dir_inc,$dir_logs,$edge_level,$edge_login;
$count='';
# if ($edge_level>=5) { # show counters only to level 5+ users
$file=str_replace('/','',$file);
$filea=$dir_inc.$dir_logs.'counters/'.$file;
if(!($fp=fopen($filea,'r'))) die ("Cannot open $filea.");
$count = (int) fread($fp,30);
fclose($fp);
# }
return $count;
}

// str_ireplace (case insensitive str_replace) introduced in PHP 5
// from PHP man
if (!function_exists('str_ireplace')) {
function str_ireplace($find,$replace,$string)
{
if(!is_array($find)) {$find = array($find);}
if(!is_array($replace)) {
if(!is_array($find)) {
$replace=array($replace);
} else {
$c = count($find);
$rString = $replace;
unset($replace);
for ($i=0;$i<$c;$i++) {
$replace[$i]=$rString;
}
}
}
foreach($find as $fKey => $fItem) {
$between=explode(strtolower($fItem),strtolower($string));
$pos=0;
foreach($between as $bKey => $bItem) {
$between[$bKey]=substr($string,$pos,strlen($bItem));
$pos+=strlen($bItem)+strlen($fItem);
}
$string=implode($replace[$fKey],$between);
}
return($string);
}
}

// stripos (case insensitive strpos) introduced in PHP 5
// from PHP man
if (!function_exists('stripos')) {
function stripos ($haystack, $needle, $offset=0) {
$haystack = substr($haystack, $offset, strlen($haystack) );
$temp = stristr($haystack, $needle);
$pos = strlen($haystack) - strlen($temp);
if ($pos == strlen ($haystack)) {$pos=FALSE;} else {$pos+=$offset;}
return $pos;
}
}

function usr_id2nick($id) {
global $edge_database_auth,$dbxcon;
$q = "SELECT login FROM `people` WHERE id = $id ";
$result = dbx_query($dbx,$dbxcon,$q,$edge_database_auth);
$row = dbx_fetch_object($dbx,$result);
return $row->login;
}

function usr_nick2id($nick) {
global $edge_database_auth,$dbxcon;
$q = "SELECT id FROM `people` WHERE login = '$nick' ";
$result = dbx_query($dbx,$dbxcon,$q,$edge_database_auth);
$row = dbx_fetch_object($dbx,$result);
return $row->id;
}

# Big Brother is watching you
function logaction($file='log',$txt='*',$f='') {
global $dir_inc,$dir_logs,$edge_log_px,$edge_log_sx;
global $edge_login,$edge_level,$edge_id;
global $edge_project_name,$edge_main_url;
global $REMOTE_ADDR;
# if ($edge_level<=8) { # doesn't log admin actions
if ($f!='N') {
switch ($f) {
case 'X':
$f='';
break;
case 'Y':
$f=date('Y');
break;
case 'M':
$f=date('Ym');
break;
case 'D':
$f=date('Ymd');
break;
}
if ($f) {$f.='_';}
if ($edge_login) {$usr=$edge_login; $usrlv=$edge_level; $usrid=$edge_id;} else {$usr='?'; $usrlv='?'; $usrid='?';}
$_dat=date('Ymd'); $_tim=date('H:i:s');
$file=str_replace('/','',$file); $file=$edge_log_px.$f.$file.$edge_log_sx;
$filea=$dir_inc.$dir_logs.$file;
if(!file_exists($filea) && is_writeable($dir_inc.$dir_logs.'counters/')){
$txto='# Dagger web engine log - '.$edge_project_name. ' - '.$edge_main_url."\n".'# LOG START: ['.$_dat.'|'.$_tim.'] '.$file."\n";
$fh=fopen($filea,'w+');
fwrite($fh,$txto);
}
if(!($fp=fopen($filea,'r'))) die ("Cannot open $filea.");
$txto=$_dat.'|'.$_tim.'|'.$REMOTE_ADDR.'|'.$usrid.'|'.$usr.'|'.$usrlv.'|'.$txt."\n";
$fp=fopen($filea,'a+');
fwrite($fp, $txto);
fclose($fp);
}
# }
}

function bbcode($txt='',$bbcodes=array()) {
if ($txt!=='' && count($bbcodes)>0) {
# $txt=htmlentities($txt);
$bbcsr=array(); $bbcrp=array();

if (in_array('b',$bbcodes)) {array_push($bbcsr,'/\[b\](.*?)\[\/b\]/is'); array_push($bbcrp,'<b>$1</b>');}
if (in_array('i',$bbcodes)) {array_push($bbcsr,'/\[i\](.*?)\[\/i\]/is'); array_push($bbcrp,'<i>$1</i>');}
if (in_array('i',$bbcodes)) {array_push($bbcsr,'/\[u\](.*?)\[\/u\]/is'); array_push($bbcrp,'<u>$1</u>');}
if (in_array('url',$bbcodes)) {array_push($bbcsr,'/\[url\=(.*?)\](.*?)\[\/url\]/is'); array_push($bbcrp,'<a href="$1" target="_blank">$2</a>'); array_push($bbcsr,'/\[url\](.*?)\[\/url\]/is'); array_push($bbcrp,'<a href="$1" target="_blank">$1</a>');}
if (in_array('mail',$bbcodes)) {array_push($bbcsr,'/\[mail\=(.*?)\](.*?)\[\/mail\]/is'); array_push($bbcrp,'<a href="mailto:$1">$2</a>'); array_push($bbcsr,'/\[mail\](.*?)\[\/mail\]/is'); array_push($bbcrp,'<a href="mailto:$1">$1</a>');}
if (in_array('align',$bbcodes)) {array_push($bbcsr,'/\[align\=(left|center|right)\](.*?)\[\/align\]/is'); array_push($bbcrp,'<div style="text-align: $1;">$2</div>');}
if (in_array('img',$bbcodes)) {array_push($bbcsr,'/\[img\](.*?)\[\/img\]/is'); array_push($bbcrp,'<img src="$1" alt="" border="0" />');}
if (in_array('font',$bbcodes)) {array_push($bbcsr,'/\[font\=(.*?)\](.*?)\[\/font\]/is'); array_push($bbcrp,'<span style="font-family: $1;">$2</span>');}
if (in_array('size',$bbcodes)) {array_push($bbcsr,'/\[size\=(.*?)\](.*?)\[\/size\]/is'); array_push($bbcrp,'<span style="font-size: $1;">$2</span>');}
if (in_array('color',$bbcodes)) {array_push($bbcsr,'/\[color\=(.*?)\](.*?)\[\/color\]/is'); array_push($bbcrp,'<span style="color: $1;">$2</span>');}

$txt = preg_replace ($bbcsr, $bbcrp, $txt);

if (in_array('quote',$bbcodes)) {
$qtopen = '<table border=1 cellpadding=3 cellspacing=3 width="100%"><tr><td>'."\n";
$qtclos = '</td></tr></table>'."\n";

preg_match_all ('/\[quote.*?\]/i', $txt, $matches);
$opentags=count($matches['0']);
preg_match_all ('/\[\/quote\]/i', $txt, $matches);
$closetags=count($matches['0']);
$unclosed=$opentags-$closetags;
if ($unclosed>0) {$txt.=str_repeat($qtclos, $unclosed);}
$txt=str_replace ('['.'quote]',$qtopen, $txt);
$txt=preg_replace ('/\[quote\ *=\ *\"(.*?)\"\]/i',$qtopen.'<b>$1:</b><br /><br />', $txt);
$txt=str_replace ('[/'.'quote]',$qtclos, $txt);
}
}
return $txt;
}

# Big Brother is censoring you
function censor($txt,$rev,$x='-',$px='',$sx='',$forb1,$md1,$forb2=array(),$md2='') {
if ($txt) {
if ($md2) {$mxf=2;} else {$mxf=1;}
for ($i=1;$i<=$mxf;$i++) {
if (sizeof(${'forb'.$i})>0) {
for ($j=0;$j<=sizeof(${'forb'.$i})-1;$j++) {
if (!$rev) {$bad=${'forb'.$i}[$j];} else {$bad=strrev(${'forb'.$i}[$j]);}
switch (${'md'.$i}) {
case 'x':
$txt=str_ireplace($bad,$px.$x.$sx,$txt);
break;
case 'xxxx':
$txt=str_ireplace($bad,$px.str_repeat($x,strlen($bad)).$sx,$txt);
break;
case 'n0':
$a=stripos($txt,$bad);
if (!($a===false)) {$txt=''; $j=sizeof(${'forb'.$i})-1;}
break;
case 'n1':
$a=stripos($txt,$bad);
if (!($a===false)) {$txt=$x; $j=sizeof(${'forb'.$i})-1;}
break;
case 'hi':
$txt=str_ireplace($bad,$px.$bad.$sx,$txt); # highlights words
break;
# case 'ax':
# case 'axxx':
# case 'axxb':
# case 'axb':
# case 'xxxb':
# case 'xb':
}
}
} else {
$i=$mxf;
}
}
}
return $txt;
}

# Big Brother is watching your country
function iptocountry($ip) {
global $dbx,$dbxcon,$edge_database;

$c='00';

    $q = "SELECT code FROM ccip WHERE ipf<=inet_aton('$ip') AND ipt>=inet_aton('$ip') ";
    $r = dbx_query($dbx,$dbxcon,$q,$edge_database);
    $cc = dbx_fetch_array($dbx,$r);
    if ($cc['code']) {$c=$cc['code'];}

return $c;
}

function isemail($email) {
$email=trim($email);
if (eregi("^[_\\.0-9a-z-]+@([_\\.0-9a-z-]+)+[a-z]{2,4}$",$email)) {$r=true;} else {$r=false;}
return $r;
}

# from PHP man, by office at rgits dot com RG IT-solutions r04-Jul-2003-11:25
# $digits = amount of chars the password should have (between 4 and 29)
# $c = if true, I,i,L,l will be changed to 1 and O or o will be changed to 0 (Zero) to prevent mistakes by an userinput
# $st = string to "U" = upper, "L" = lower, null=casesensitive
# example: $pw=pwgen(8,true,null);
function pwgen($digits,$c=false,$st=null) {
  if (!ereg("^([4-9]|((1|2){1}[0-9]{1}))$",$digits)) # 4-29 chars allowed
     $digits=4;
  for(;;) {
     $pwd=null; $o=null;
     # Generates the password
     for ($x=0;$x<$digits;) {
        $y = rand(1,1000);
       if($y>350 && $y<601) $d=chr(rand(48,57));
        if($y<351) $d=chr(rand(65,90));
        if($y>600) $d=chr(rand(97,122));
        if($d!=$o) {
         $o=$d; $pwd.=$d; $x++;
        }
     }
     # if you want that the user will not be confused by O or 0 ("Oh" or "Null") or 1 or l ("One" or "L"), set $c=true;
     if($c) {
        $pwd=eregi_replace("(l|i)","1",$pwd);
        $pwd=eregi_replace("(o)","0",$pwd);
     }
    # If the PW fits your purpose (e.g. this regexpression) return it, else make a new one (You can change this regular-expression how you want ....)
    if(ereg("^[a-zA-Z]{1}([a-zA-Z]+[0-9][a-zA-Z]+)+",$pwd))
      break;
  }
  if ($st=="L") {$pwd=strtolower($pwd);} elseif ($st=="U") {$pwd=strtoupper($pwd);}
  return $pwd;
}

function richtextarea($nam,$param='cols=75 rows=5',$v='',$riche='1') {
global $pagdirx, $inp_richedit;

if ($inp_richedit && auth_privil($pagdirx,'WYW') && $riche>0) {
$aid='rtxt'.$riche;
} else {
$aid='rtxt0';
}
echo '<textarea id="'.$aid.'" name="'.$nam.'" '.$param.'>'.$v.'</textarea>';
}

function spellchecklink($nform,$nfield,$riched=false) {
global $pagdirx, $inp_spellck, $inp_richedit;

if ($inp_spellck && auth_privil($pagdirx,'SPL')) {
echo '<a href="'.$edge_main_url.'spell_check.php?init=nojs" onclick="javascript:';
if ($riched && $inp_richedit && auth_privil($pagdirx,'WYW')) {
echo 'var thelart=thelarea._editMode;thelarea.setMode(\'textmode\');';
}
echo 'SpellCheck(\''.$nform.'\',\''.$nfield.'\');';
// if ($riched && $inp_richedit && auth_privil($pagdirx,'WYW')) {echo 'thelarea.setMode(thelart);';}
echo 'return false;">';
echo '* '.'Spell Check';
echo '</a>';
}
}

function safefilename($fn='',$c=0) {
$fn=preg_replace("/( |\+|\\|\/|\:|\*|\?|\"|\<|\>|\|)/",'_',$fn); $fn=preg_replace("/(_)+/",'_',$fn);
if ($c==1) {$fn=strtolower($fn);} elseif ($c==2) {$fn=strtoupper($fn);}
return $fn;
}

function randrowobj($dbx,$dbxcon,$db_name,$table,$fields='*',$cond='') {
# Much faster than "SELECT * FROM $table $cond ORDER BY RAND(now()) LIMIT 1";
$qdb="SELECT FLOOR(RAND(now()) * COUNT(*)) AS rndrow FROM ".$table." ".$cond." ;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$dbr=dbx_fetch_object($dbx,$dbo);
$qdb="SELECT ".$fields." FROM ".$table." ".$cond." LIMIT ".$dbr->rndrow.",1 ;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$dbr=dbx_fetch_object($dbx,$dbo);
return $dbr;
}

function randrowarr($dbx,$dbxcon,$db_name,$table,$fields='*',$cond='') {
# Much faster than "SELECT * FROM $table $cond ORDER BY RAND(now()) LIMIT 1";
$qdb="SELECT FLOOR(RAND(now()) * COUNT(*)) AS rndrow FROM ".$table." ".$cond." ;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$dbr=dbx_fetch_array($dbx,$dbo);
$qdb="SELECT ".$fields." FROM ".$table." ".$cond." LIMIT ".$dbr['rndrow'].",1 ;";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$dbr=dbx_fetch_array($dbx,$dbo);
return $dbr;
}

# if (auth_user('AUS')) {$uau4=true;} else {$uau4=false;}
function auth_usrvw($f) {
global $row_user,$edge_logged,$edge_login,$edge_privil,$edge_level,$lvl_privil,$usrprof;
if ($edge_logged && $edge_login==$name) {$uau3=true;} else {$uau3=false;}
if (auth_user('AUS')) {$uau4=true;} else {$uau4=false;}
$v=FALSE;
list ($l_1a,$l_1b) = explode('|',$usrprof[$f]);
if ($l_1a>0 && $l_1b>0) {
switch ($l_1b) {
case 1:
$v=TRUE; break;
case 2:
if ($edge_logged) {$v=TRUE;}
case 3:
if ($uau3 || $uau4) {$v=TRUE;}
break;
case 4:
if ($uau4) {$v=TRUE;}
break;
}
}
if ($v && substr($f,0,2)!='xx' && $row_user->$f=='') {$v=FALSE;}	# exclude non-existing and empty fields
return $v;
}

function auth_usrrg($f) {
global $usrprof;
$v=FALSE;
list ($l_1a) = explode('|',$usrprof[$f]);
if ($l_1a>0) {$v=TRUE;}
return $v;
}

function auth_dbdat($f,$dbdat) {
$v=FALSE;
list ($l_1a) = explode('|',$dbdat[$f]);
if ($l_1a>0) {$v=TRUE;}
return $v;
}

function shw_mandat($f) {
global $edge_bgcolor;
global $usrprof;
$v='';
list ($l_1a) = explode('|',$usrprof[$f]);
if ($l_1a==3) {$v='bgcolor="'.$edge_bgcolor.'"';}
return $v;
}

function shw_mandat2($f,$m=1) {
global $usrprof;
if ($m!=2) {$m=1;}
$v='';
list ($l_1a) = explode('|',$usrprof[$f]);
if ($l_1a==3) {
if ($m==1) {
$v='<sup>*</sup>';
} else {
$v='required ';
}
}
return $v;
}

function is_mand($k) {
list ($r) = explode('|',$k);
if ($r==3) {$r=true;} else {$r=false;}
return $r;
}

function minlenprof($k) {
if ($k) {
list ($mn) = explode('|',$k);
} else {$mn=false;}
return $mn;
}

function maxlenprof($k) {
if ($k) {
list ($mn,$mx) = explode('|',$k);
} else {$mx=false;}
return $mx;
}

function maxlenprofp($k) {
if ($k) {
list ($mn,$mx) = explode('|',$k);
if ($mx>0) {$r='maxlength='.$mx;} else {$r='';}
} else {$r='';}
return $r;
}

include('functions_x.php');

?>