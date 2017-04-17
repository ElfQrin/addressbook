<?

# Dagger Configuration

define('IN_ENGINE','1');	# test this static in includes to check if it has been invoked from the script: if (!defined('IN_ENGINE')) {die('forbidden');}

# Check for mobile devices (this should stay in site_header.php )
# if (preg_match('/(pre\/|mobi|symbian|windows ce|samsung-sgh|fennec|palm|avantgo|hiptop|plucker|xiino|blazer|elaine)/i',$_SERVER['HTTP_USER_AGENT'])) {$mobi=true;} else {$mobi=false;}

# Project info
$edge_project_name='Address Book';
$edge_html_title='Address Book'; # title used in <title> tag
$edge_webmaster_name='myname';
$edge_webmaster_email='webmaster@mysite.example.com';
$edge_meta_own=$edge_webmaster_name;	# you may change this in case you create a site for someone else


# Server settings
$dbx='mysqli'; # Database Type: MySQL, MySQLi, PostgreSQL
$edge_database_host='localhost';
$edge_mysql_username='mysqlusername';	# mysql user with proper rights for the host and database
$edge_mysql_password='mysqlpassword';
$edge_database='addressbook';	# the database where the content is stored
# $edge_database_auth='';	# the database, from where the system gets users/passwords (table 'people') (doesn't necessarily need to be the same)
$edge_use_mcrypt=1;	# encryption type: 0=plain text (not recommended, deprecated), 1=XOR (very weak), 2=mcrypt (require PHP>=4.0.4p1 with mcrypt libraries installed and php compiled with --with-mcrypt, not recommended), 3=Blowfish (safer but slower)
$edge_mcrypt_password='mycryptpassword';	# this password is used for the alternate encryption algorithm as well
$edge_servertz = 0;	# server timezone (UTC +/- ?); can be a float number example: -10, +3.5, EST = -6, GMT = 0, CET = 1, etc.
// ini_set("SMTP","localhost"); ini_set("smtp_port",25);	# ini_set: overrides php.ini SMTP configuration


# Directories
$edge_servr='www.example.com';
$edge_serv='http://'.$edge_servr.'/'; # don't edit this line
$dir_edge='address_book/';	# leave blank if the script is installed in the root directory
$edge_main_url=$edge_serv.$dir_edge; # don't edit this line
if (substr($_SERVER['REQUEST_URI'],0,strlen('/'.$dir_edge)) != '/'.$dir_edge && $_SERVER['HTTP_HOST'] == $edge_servr) die('unauthorized');  # prevents script hijacking
# if ($_SERVER['HTTP_HOST'] != $edge_servr) die('url redirection not allowed');  # disallows url redirection
$dir_edge_lang='lang/';
$dir_logs='logs/';	# this directory and its subdirectories (like counters) must have write access for httpd processes (CHMOD 666 or 777) and should be password protected to prevent unauthorized people to access logs
$dir_edge_skins='skins/';
$dir_inc=$_SERVER['DOCUMENT_ROOT'].$dir_edge; # Include path for subdirectories. - If $DOCUMENT_ROOT requires a trailing slash ("/") use $dir_inc=$_SERVER['DOCUMENT_ROOT'].'/'.$dir_edge; - If $DOCUMENT_ROOT is not accurate, you'll have to set $dir_inc manually. Example: $dir_inc='/home/user/public_html/dagger/';
$edge_uploadwww='upload';
$edge_uploaddir=$dir_inc.$edge_uploadwww;	# don't edit this line. where to upload files by users, must have write access for httpd processes (at least CHMOD 666)
$edge_uploadwww='/'.$dir_edge.$edge_uploadwww;	# don't edit this line. this is because the file upload code requires a leading slash
$edge_mobs='/mobs';	# directory for media objects (inside $edge_uploadwww ), must have write access for httpd processes (at least CHMOD 666)


# Language and Charset
$edge_language='en';
$edge_charset = 'ISO-8859-1'; # default value, will be overriden by language file, if set
$edge_multibyte=false; # is the page running multibyte charset


# Address Book

# Simulate an user
$edge_logged=true; # Logged User
$edge_privil='CREATE,ADD,EDIT,STAR1,STARM,DEL1,DELM,DELA,SEARCH,EXPORT'; # User Privileges: CREATE, ADD, EDIT, STAR1, STARM, DEL1, DELM, DELA, SEARCH, EXPORT
$edge_level = 0; $edge_id = 0; $edge_email = ''; $edge_ccode = ''; # Edge Engine Legacy

$db_host=$edge_database_host;
$db_user=$edge_mysql_username;
$db_pwd=$edge_mysql_password;
$db_name=$edge_database;
$db_table1_name='contacts';

# Enabled Functions (0: disabled, 1: enabled):
$functen = array('create'=>1,'add'=>1,'edit'=>1,'view'=>1,'search'=>1,'export'=>1,'stats'=>1,'remove'=>1);

# Add : 0 - disabled, 1 - enabled but not modifiable by the user, 2 - enabled, 3 - enabled and mandatory ("required")
# Show: 0 - disabled, 1 - enabled and viewable, 5 - enabled but not viewable (example: hashed password)
$dbdat = array ('starr'=>'2|1','name'=>'2|1','lname'=>'3|1','gend'=>'2|1','bday'=>'2|1','address'=>'2|1','phonecell'=>'2|1','email'=>'2|1','www'=>'0|0');

# Minimal information to identify an item. Used for the interactive list of items (edit, delete)
if (!$mobi) {
$minimitems = array('name', 'lname', 'email'); # Compact view for Desktop devices
} else {
$minimitems = array('name', 'lname'); # Ultra compact view for Mobile devices
}

$defsrt='`lname`,`name`'; # Default sort order
# $defsrt='`id`'; # Default sort order

# min/max lenght of user profile text fields (make sure max values are not bigger than the ones defined in the database)
$dbdatlen = array ('name'=>'0|128','lname'=>'0|128','address'=>'0|128','phonecell'=>'0|24','email'=>'5|128','www'=>'0|128');

# Forbidden words
$forbw['name']=array('admin','manager','daemon','hostmaster','postmaster','webmaster','superuser','superbot'); # list of forbidden words
$forbr='-';	# replace forbidden words with this string

$showef=true; # Show empty fields in the database (the output format might not allow to hide empty fields, in such case this setting will be ignored)

$starr=true; # enable/disable starred items (Special / Favorite / Sticky)
$starrbl=1; # Starred items behavior when listed: 0: Unchanged, 1: Show first, 2: Show last 

$user_email=1;	# e-mail output format: 1 = normal, 2 = obfuscated

$itmppagdef=10; # Items per page

$srchqminlen=3; # Minimum length in characters of a search string

$askc_del1=true; # ask confirmation for single deletion
$askc_delm=true; # ask confirmation for deleting multiple items
$askc_dela=true; # ask confirmation for deleting all items or removing the database

?>