<?
define('PAGETITLE','Address Book - Create the Database');
include('site_header.php');

if ($functen['create']!=1) {fdisabled(); die();}
if (!auth_user('CREATE')) {authdenied(); die();}

echo '<center>'.'<h1>'.'Create the Database'.'</h1>'.'</center>';

# $qdb="CREATE DATABASE IF NOT EXISTS `".$db_name."`"; # Create a new database
$qdb="";
$qdb.="
CREATE TABLE IF NOT EXISTS `".$db_table1_name."` (
`id` bigint(20) NOT NULL auto_increment,
`dat` bigint(20) NOT NULL default '0',
`starr` tinyint(1) NOT NULL default '0',
`name` varchar(128) NOT NULL default '',
`lname` varchar(128) NOT NULL default '',
`gend` tinyint(4) NOT NULL default '0',
`bday` varchar(8) NOT NULL default '00000000',
`address` text NOT NULL default '',
`phonecell` varchar(32) NOT NULL default '',
`email` varchar(128) NOT NULL default '',
`www` varchar(128) NOT NULL default '',
PRIMARY KEY  (`id`),
KEY `dat` (`dat`),
KEY `starr` (`starr`),
KEY `name` (`name`),
KEY `gend` (`gend`),
KEY `bday` (`bday`),
KEY `phonecell` (`phonecell`),
KEY `www` (`www`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
"; # Create a new table

$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);

echo '<br /><br />';
echo 'Database created';

include('site_footer.php');
?>