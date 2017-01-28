<? if (!defined('IN_ENGINE')) {die('forbidden');}

$dbi=array();
$dbi['starr'] = 0;
$dbi['name'] = '';
$dbi['lname'] = '';
$dbi['gend'] = 0;
$dbi['bdayd'] = 1;
$dbi['bdaym'] = 1;
$dbi['bdayy'] = '';
if (mktime(0,0,0,$dbi['bdaym'],$dbi['bdayd'],$dbi['bdayy'])<=0) {$dbi['bday'] ='00000000';} else {$dbi['bday'] = str_pad(floor($dbi['bdayy']),4,'0',STR_PAD_LEFT).str_pad($dbi['bdaym'],2,'0',STR_PAD_LEFT).str_pad($dbi['bdayd'],2,'0',STR_PAD_LEFT);}
$dbi['address'] = '';
$dbi['phonecell'] = '';
$dbi['email'] = '';
$dbi['www'] = '';

?>