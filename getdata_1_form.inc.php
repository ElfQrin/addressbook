<? if (!defined('IN_ENGINE')) {die('forbidden');}

$dbi=array();
$dbi['starr'] = addslashes(trim($_POST['starr']));
if ($dbi['starr']!=1) {$dbi['starr']=0;}
$dbi['name'] = addslashes(trim($_POST['name']));
$dbi['lname'] = addslashes(trim($_POST['lname']));
$dbi['gend'] = floor((trim($_POST['gend'])));
$dbi['bdayd'] = floor($_POST['bdayd']);
$dbi['bdaym'] = floor($_POST['bdaym']);
$dbi['bdayy'] = floor($_POST['bdayy']);
if (mktime(0,0,0,$dbi['bdaym'],$dbi['bdayd'],$dbi['bdayy'])<=0) {$dbi['bday'] ='00000000';} else {$dbi['bday'] = str_pad(floor($dbi['bdayy']),4,'0',STR_PAD_LEFT).str_pad($dbi['bdaym'],2,'0',STR_PAD_LEFT).str_pad($dbi['bdayd'],2,'0',STR_PAD_LEFT);}
$dbi['address'] = addslashes(trim($_POST['address']));
$dbi['phonecell'] = addslashes(trim($_POST['phonecell']));
$dbi['email'] = addslashes(trim($_POST['email']));
$dbi['www'] = addslashes(trim($_POST['www']));

?>