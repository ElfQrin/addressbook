<?
define('PAGETITLE','Address Book - Add/Edit Item');
include('site_header.php');

$id=false;

$action=strtolower(trim($_REQUEST['action'])); # Action (Add, Edit)
if ($action!='edit') {$action='add';} # Set default action

if ($action=='add') {
if ($functen['add']!=1) {fdisabled(); die();}
if (!auth_user('ADD')) {authdenied(); die();}
} else {
if ($functen['edit']!=1) {fdisabled(); die();}
if (!auth_user('EDIT')) {authdenied(); die();}
}

if ($action=='add') {
echo '<center>'.'<h1>'.'Add a new item'.'</h1>'.'</center>';
} else {
echo '<center>'.'<h1>'.'Edit an item'.'</h1>'.'</center>';
}


$xgo=strtolower(trim($_REQUEST['xgo']));

if ($xgo=='1') {

if ($action=='edit') {
$id=$_REQUEST['id'];
include('getdata_1_db.inc.php');
}
include('getdata_1_form.inc.php');

$do=true;

# Check for mandatory fields
$dbemdm=0;
foreach ($dbdat as $key=>$value) {
if (is_mand($value)) {
if (!$dbi[$key]) {
$do=false; $dbemdm++;
echo 'Missing mandatory entry'.': '.'<b>'.$key.'</b><br />';
}
}
}
if ($dbemdm==1) {
echo 'There\'s a mandatory field missing.'."<br />";
} elseif ($dbemdm>1) {
echo 'There are '.$dbemdm.' mandatory fields missing.'."<br />";
}

# Check for invalid/inappropriate words
$dbi['name']=censor($dbi['name'],false,$forbr,'','',$forbw['name'],'n0'); $dbi['name']=censor($dbi['name'],true,$forbr,'','',$forbw['name'],'n0');
$dbi['lname']=censor($dbi['lname'],false,$forbr,'','',$forbw['name'],'n0'); $dbi['lname']=censor($dbi['lname'],true,$forbr,'','',$forbw['name'],'n0');
if (!$dbi['name']) {$do=false; echo 'Name field contains invalid words.'."<br />";}
if (!$dbi['lname']) {$do=false; echo 'Last Name field contains invalid words.'."<br />";}

# Check for Min/Max field size
foreach ($dbdatlen as $key=>$value) {
if ($dbi[$key]) {
if (minlenprof($value)>strlen($dbi[$key])) {
$do=false; echo '<b>'.$key.'</b>'.' '.'min.'.' '.minlenprof($value).' '.'characters'."<br />";
}
if (maxlenprof($value)<strlen($dbi[$key])) {
$do=false; echo '<b>'.$key.'</b>'.' '.'max.'.' '.maxlenprof($value).' '.'characters'."<br />";
}
}
}

# Validate e-mail address
if ($dbi['email'] && !isemail($dbi['email'])) {$do=false; echo 'invalid e-mail address'."<br />";}

# Avoid entries with the same e-mail
$qdb="SELECT id,email FROM `".$db_table1_name."` WHERE email = '".$dbi['email']."';";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);
$row=dbx_fetch_array($dbx,$dbo);
if ($row['email'] && $row['email']!='' && ($action=='add' || ($action=='edit' && $id!=$row['id']))) {$do=false; echo 'A contact with the given e-mail already exists'."<br />";}

if ($do) {
$qdb="";

$dat=time();              
// $epassword=pw_enc($password,$edge_mcrypt_password,$edge_use_mcrypt); // hash password

if ($action=='add') {
$qdb="INSERT INTO `".$db_table1_name."` (`starr`,`name`,`lname`,`gend`,`bday`,`address`,`phonecell`,`email`,`www`,`dat`) VALUES ('".$dbi['starr']."','".$dbi['name']."','".$dbi['lname']."','".$dbi['gend']."','".$dbi['bday']."','".$dbi['address']."','".$dbi['phonecell']."','".$dbi['email']."','".$dbi['www']."',".$dat.");";
} else {
$qdb="UPDATE `".$db_table1_name."` SET `starr` = '".$dbi['starr']."', `name` = '".$dbi['name']."', `lname` = '".$dbi['lname']."', `gend` = '".$dbi['gend']."', `bday` = '".$dbi['bday']."', `address` = '".$dbi['address']."', `phonecell` = '".$dbi['phonecell']."', `email` = '".$dbi['email']."', `www` = '".$dbi['www']."', `dat` = '".$dat."' WHERE `id` = ".$id.";";
}
# echo "<br />".$qdb."<br />";
$dbo=dbx_query($dbx,$dbxcon,$qdb,$db_name);

if ($dbo) {
if ($action=='add') {echo 'Entry added'."<br />";} else {echo 'Entry updated'."<br />";}
} else {
if ($action=='add') {echo 'ERROR: Entry not added'."<br />";} else {echo 'ERROR: Entry not updated'."<br />";}
}

}

echo "<br />";
}

# echo '<strong>'.'Fill the form'.'</strong>'."<br /><br />";

if ($action=='add') {
include('getdata_1_default.inc.php');
} else {
if ($xgo!='1') {
$id=$_REQUEST['id'];
$qdbs1='*';
include('getdata_1_db.inc.php');
}
}

include('formdata_1.inc.php');

include('site_footer.php');
?>