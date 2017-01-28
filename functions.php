<?
function echx($handle,$ou) {
if (!$handle) {
echo $ou;
} else {
fwrite($handle,$ou);
}
}

function htmlinputval($x) {
# return str_replace("'",'&apos;',str_replace("\\'",'&apos;',str_replace('"','&quot;',str_replace('\"','&quot;',$x))));
return htmlspecialchars(stripslashes($x),ENT_QUOTES);
}

function htmlspecialchars_mb($x) {
global $edge_multibyte, $edge_charset;
if ($edge_multibyte) {
return(htmlspecialchars($x,ENT_COMPAT,$edge_charset));
} else {
return(htmlspecialchars($x));
}
}

function checkint($x) {
if ($x===0) {return (0);}
if ($x!='') {
if (preg_match('/^-?\d+$/',$x)) {return $x;}
}
return('');
}

function isemail($email) {
$email=trim($email);
if (eregi("^[_\\.0-9a-z-]+@([_\\.0-9a-z-]+)+[a-z]{2,4}$",$email)) {$r=true;} else {$r=false;}
return $r;
}

function shwemail($vin,$mod) {
$vou=$vin;
if ($mod==2) {$vou=str_replace('@',' AT ',$vou); $vou=str_replace('.',' DOT ',$vou);}
return $vou;
}

function dateread($vin,$sep='/') {
if (strlen($vin)>=8) {$vou=substr($vin,4,2).$sep.substr($vin,6,2).$sep.substr($vin,0,4);} else {$vou=$vin;}
return $vou;
}

function auth_usrrg($f) {
global $usrprof;
$v=false;
list ($l_1a) = explode('|',$usrprof[$f]);
if ($l_1a>0) {$v=true;}
return $v;
}

function auth_dbdat($f,$dbdat) {
$v=FALSE;
list ($l_1a) = explode('|',$dbdat[$f]);
if ($l_1a>0) {$v=TRUE;}
return $v;
}

function shw_mandat($f,$m=1) {
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

function prpagnum($pag,$itmppag,$mxitm,$pagurl,$pagq='?') {

if (!$pagq) {$pagq='?';}
if ($itmppag<1) {$itmppag=10;}

$mxpag=ceil($mxitm/$itmppag);

if ($mxpag>1) {

if($pag!=1) {
echo "<a href=\"".$pagurl.$pagq."pag=".($pag-1)."\">&lt;".'-'."</a> ";
} 

for ($i=1;$i<=$mxpag;$i++) {
if ($i!=$pag) {
echo "<a href=\"".$pagurl.$pagq."pag=".$i."\">".$i.'</a> ';
} else {
echo '<b>'.$i.'</b> ';
}
}

if($pag<$mxpag) {
echo "<a href=\"".$pagurl.$pagq."pag=".($pag+1)."\">".'-'."&gt;</a> ";
} 

}

return;
}

function auth_usrvwx($f,$usrprof) {
# echo '['.$f.']['.$usrprof[$f].']';
$v=false;
list ($l_1a,$l_1b) = explode('|',$usrprof[$f]);
if ($l_1a>0 && $l_1b>0) {
switch ($l_1b) {
case 1:
$v=true;
break;
}
}
if (substr($f,0,2)=='xx') {$v=false;} # exclude invalid fields
return $v;
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

function authdenied() {
echo 'authorization denied';
}

function fdisabled() {
echo 'Function unavailable';
}

/*
function optionsel($a,$s='') {
for ($i=0;$i<=count($a)-1;$i++) {
if ($s!='' && ($a[$i]==$s)) {$b=' selected';} else {$b='';}
echo '<option value="'.$a[$i].'"'.$b.'>'.$a[$i].'</option>\n';
}
}

function optionseln($a,$s='') {
for ($i=0;$i<=count($a)-1;$i++) {
if ($s!='' && ($i==$s)) {$b=' selected';} else {$b='';}
echo '<option value="'.$i.'"'.$b.'>'.$i.'. '.$a[$i].'</option>\n';
}
}
*/
?>
