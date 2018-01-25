<?

# DBX Wrapper: MySQL, MySQLi, PostgreSQL, SQLite
# By Valerio Capello ( http://labs.geody.com/ ) r2018-01-23 fr2016-09-21
# License: GPL v3.0


# Functions

function explodex($s,$nx='.',$ord=0,$mod=false) {
$rt=array(false,false);
switch ($ord) {
default:
case 0:
# truncate the string keeping characters up to the last X matching character (excluded: will be removed)
$r=strrpos($s,$nx); if ($r!==false) {$rt[0]=substr($s,0,$r);}
# truncate the string keeping characters from the last X matching character (excluded: will be removed)
$rn=strlen($s); $r=strrpos($s,$nx); if ($r!==false && $r<$rn) {$rt[1]=substr($s,$r+1,$rn);}
break;
case 1:
# truncate the string keeping characters up to the first X matching character (excluded: will be removed)
$r=strpos($s,$nx,0); if ($r!==false) {$rt[0]=substr($s,0,$r);}
# truncate the string keeping characters from the first X matching character (excluded: will be removed)
$rn=strlen($s); $r=strpos($s,$nx,0); if ($r!==false && $r<$rn) {$rt[1]=substr($s,$r+1,$rn);}
break;
}
if ($mod && $rt[0]===false && $rt[1]===false) {$rt[0]=$s;}
return $rt;
}


# DB Functions

# Requires function explodex()
function dbx_connect($dbx,$db_host,$db_user,$db_pwd,$db_name='') {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_connect($db_host,$db_user,$db_pwd);
break;
case 'mysqli':
$db_host_1=explodex($db_host,':',0,true);
if ($db_host_1[1]!==false) {$r=mysqli_connect($db_host,$db_user,$db_pwd,$db_name,$db_host_1[1]);} else {$r=mysqli_connect($db_host,$db_user,$db_pwd,$db_name);}
break;
case 'postgresql':
# $r=pg_connect($db_host1, $db_port, , , $db_name); # deprecated
$db_host_1=explodex($db_host,':',0,true);
if ($db_host_1[1]!==false) {$db_portz=' port='.$db_host_1[1].' ';} else {$db_portz=' ';}
$r=pg_connect("host=".$db_host_1[0].$db_portz."dbname=".$db_name." user=".$db_user." password=".$db_pwd);
break;
case 'sqlite':
$r=sqlite_open($db_host); # $db_host contains the file name of the SQLite Database
break;
}
return $r;
}

function dbx_connect_pt($dbx,$db_host,$db_port=false,$db_user,$db_pwd,$db_name='') {
$dbx=strtolower(trim($dbx));
if ($db_port!==false) {
$r=dbx_connect($dbx,$db_host.':'.$db_port,$db_user,$db_pwd,$db_name);
} else {
$r=dbx_connect($dbx,$db_host,$db_user,$db_pwd,$db_name);
}
return $r;
}

function dbx_close($dbx,$dbxcon) {
$dbx=strtolower(trim($dbx));
switch ($dbx) {
case 'mysql':
mysql_close($dbxcon);
break;
case 'mysqli':
mysqli_close($dbxcon);
break;
case 'postgresql':
pg_close($dbxcon);
break;
case 'sqlite':
sqlite_close($dbxcon);
break;
}
}

function dbx_query($dbx,$dbxcon,$dbq,$db_name='') {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_db_query($db_name,$dbq,$dbxcon);
break;
case 'mysqli':
$r=mysqli_query($dbxcon,$dbq);
break;
case 'postgresql':
# $dbxcon=pg_connect("dbname=".$db_name);
$r=pg_query($dbxcon,$dbq);
break;
case 'sqlite':
$r=sqlite_query($dbxcon,$dbq);
break;
}
return $r;
}

function dbx_num_rows($dbx,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_num_rows($dbo);
break;
case 'mysqli':
$r=mysqli_num_rows($dbo);
break;
case 'postgresql':
$r=pg_num_rows($dbo);
break;
case 'sqlite':
$r=sqlite_num_rows($dbo);
break;
}
return $r;
}

function dbx_affected_rows($dbx,$dbxcon,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_affected_rows();
break;
case 'mysqli':
$r=mysqli_affected_rows($dbxcon);
break;
case 'postgresql':
$r=pg_affected_rows($dbo);
break;
case 'sqlite':
$r=sqlite_changes($dbxcon);
break;
}
return $r;
}

function dbx_fetch_array($dbx,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_fetch_array($dbo);
break;
case 'mysqli':
$r=mysqli_fetch_array($dbo);
break;
case 'postgresql':
$r=pg_fetch_array($dbo);
break;
case 'sqlite':
$r=sqlite_fetch_array($dbo);
break;
}
return $r;
}

function dbx_fetch_object($dbx,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_fetch_object($dbo);
break;
case 'mysqli':
$r=mysqli_fetch_object($dbo);
break;
case 'postgresql':
$r=pg_fetch_object($dbo);
break;
case 'sqlite':
$r=sqlite_fetch_object($dbo);
break;
}
return $r;
}

function dbx_fetch_row($dbx,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_fetch_row($dbo);
break;
case 'mysqli':
$r=mysqli_fetch_row($dbo);
break;
case 'postgresql':
$r=pg_fetch_row($dbo);
break;
case 'sqlite':
# $r=sqlite_fetch_row($dbo);
$r=''; # Unimplemented
break;
}
return $r;
}

function dbx_fetch_assoc($dbx,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_fetch_assoc($dbo);
break;
case 'mysqli':
$r=mysqli_fetch_assoc($dbo);
break;
case 'postgresql':
$r=pg_fetch_assoc($dbo);
break;
case 'sqlite':
# $r=sqlite_fetch_assoc($dbo);
$r=''; # Unimplemented
break;
}
return $r;
}

function dbx_data_seek($dbx,$dbo,$row) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_data_seek($dbo,$row);
break;
case 'mysqli':
$r=mysqli_data_seek($dbo,$row);
break;
case 'postgresql':
$r=pg_result_seek($dbo,$row);
break;
case 'sqlite':
if ($row==0) {$r=sqlite_rewind($dbo);} else {$r=sqlite_seek($dbo,$row);}
break;
}
return $r;
}

function dbx_insert_id($dbx,$dbxcon) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_insert_id($dbxcon);
break;
case 'mysqli':
$r=mysqli_insert_id($dbxcon);
break;
case 'postgresql':
# $r=pg_insert_id($dbo);
$r=''; # Unimplemented
break;
case 'sqlite':
$r=sqlite_last_insert_rowid($dbxcon);
break;
}
return $r;
}

function dbx_free_result($dbx,$dbo) {
$dbx=strtolower(trim($dbx));
$r=false;
switch ($dbx) {
case 'mysql':
$r=mysql_free_result($dbo);
break;
case 'mysqli':
$r=mysqli_free_result($dbo);
break;
case 'postgresql':
$r=pg_free_result($dbo);
break;
case 'sqlite':
$r=true;
break;
}
return $r;
}

function dbx_last_error($dbx,$dbxcon) {
$dbx=strtolower(trim($dbx));
switch ($dbx) {
case 'mysql':
$r=mysql_error($dbxcon);
break;
case 'mysqli':
$r=mysqli_error($dbxcon);
break;
case 'postgresql':
$r=pg_last_error($dbxcon);
break;
case 'sqlite':
$r=sqlite_last_error($dbxcon);
break;
}
return $r;
}

function dbx_server_info($dbx,$dbxcon) {
$dbx=strtolower(trim($dbx));
switch ($dbx) {
case 'mysql':
$r=mysql_get_server_info($dbxcon);
break;
case 'mysqli':
$r=mysqli_get_server_info($dbxcon);
break;
case 'postgresql':
$r=pg_version($dbxcon);
break;
case 'sqlite':
$r=sqlite_libversion($dbxcon);
break;
}
return $r;
}

# Requires dbx_query, dbx_fetch_array
function dbx_sel_rand($dbx,$dbxcon,$db_name,$db_table,$idfield,$numel=1,$condit='',$order='') {
if ($condit) {$conditq=' WHERE ('.$condit.')';}
$qdb='SELECT COUNT(*) as c FROM `'.$db_table.'`'.$conditq.' ;';
# echo '['.$qdb.']'."<br />\n";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
if ($dbo) {$row=dbx_fetch_array($dbx,$dbo);} else {$row=array('c'=>0);}
# echo 'Total Rows'.': '.$row['c']."<br /><br />\n";

if ($row['c']>$numel*2) {
# echo '<b>'.'Method: Alt'.'</b>'."<br />\n";

if ($condit) {$conditq=' && ('.$condit.')';}
$qdb='SELECT `'.$idfield.'` FROM `'.$db_table.'` WHERE RAND(now())*'.$row['c'].'<'.($numel*2).$conditq.' ORDER BY RAND(now()) LIMIT '.$numel.' ;';
# $qdb='SELECT `'.$idfield.'` FROM `'.$db_table.'`'.$conditq.' ORDER BY RAND(now()) LIMIT '.$numel.' ;';
# echo '[1:'.$qdb.']'."<br />\n";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$ids='';
while ($row=dbx_fetch_array($dbx,$dbo)) {
if ($ids) {$ids.=','.$row[$idfield];} else {$ids=$row[$idfield];}
}

if ($order!=='') {$order=' ORDER BY '.$order;}
$qdb='SELECT * FROM  `'.$db_table.'` WHERE `'.$idfield.'` IN('.$ids.')'.$order.' ;';
# echo '[1b:'.$qdb.']'."<br />\n";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);

} else {
# echo '<b>'.'Method: Org'.'</b>'."<br />\n";
if ($order!=='') {$order=','.$order;}
$qdb='SELECT * FROM `'.$db_table.'`'.$conditq.' ORDER BY RAND(now())'.$order.' LIMIT '.$numel.' ;';
# echo '[2:'.$qdb.']'."<br />\n";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
}

return $dbo;
}

# Connect to the Database: $dbxcon=dbx_connect($dbx,$db_host,$db_user,$db_pwd,$db_name);

?>
