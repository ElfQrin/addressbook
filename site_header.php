<?
define('IN_ENGINE','1'); # test this static in includes to check if it has been invoked from the script: if (!defined('IN_ENGINE')) {die('forbidden');}
include('bios.inc.php');
?>
<html>
<head>
<META NAME="Abstract" CONTENT="Address Book" />
<META NAME="Description" CONTENT="Address Book" />
<META NAME="Keywords" CONTENT="Address Phone Book Contacts" />
<META NAME="Generator" CONTENT="<? echo 'Dagger web engine'; ?>" />
<META NAME="Author" CONTENT="<? echo $edge_webmaster_name; ?>" />
<META NAME="Owner" CONTENT="<? echo $edge_meta_own; ?>" />
<META NAME="Copyright" CONTENT="<? echo $edge_main_url; ?>legal.php" />
<META NAME="Content-Language" CONTENT="<? echo $edge_language; ?>" />
<META NAME="Rating" CONTENT="General" />
<META NAME="pics-label" CONTENT="General" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<META NAME="Robots" CONTENT="index,follow" />
<META NAME="Distribution" CONTENT="Global" />
<META NAME="MSSmartTagsPreventParsing" CONTENT="TRUE" />
<LINK REL="Shortcut Icon" HREF="<? echo $edge_main_url; ?>favicon.ico" TYPE="image/x-icon" />
<LINK REL="Icon" HREF="<? echo $edge_main_url; ?>favicon.ico" TYPE="image/x-icon" />
<LINK REL="Top" HREF="<? echo $edge_main_url; ?>" />
<LINK REL="Copyright" HREF="<? echo $edge_main_url; ?>legal.php" />
<title><?
if (!defined('PAGETITLE')) {
echo $edge_html_title;
} else {
echo PAGETITLE;
}
?></title>
<link rel="stylesheet" type="text/css" href="<? if (!$mobi) {echo 'default.css';} else {echo 'default_mobi.css';} ?>">
<?
# include('functions_js.inc.php');
?>
</head>
<body bgcolor="#FFFFFF">
<a name="top"></a>
<?
# echo '<center>','<table border=0 cellpadding=0 cellspacing=0 width="780"><tr>','<td bgcolor="#FFFFFF" valign=top>';
include('hdr-top.inc.php');
include('menu.inc.php');
?>
