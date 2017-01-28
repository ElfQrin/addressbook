<?

function fmtoitem($outfmt,$key='',$val='') {
global $cp, $xnel, $dbey;
if ($key=='Fav' || $key=='Star') { if ($val==1) {$val='*';} else {$val='-';} }
if ($key=='Name' || $key=='Last Name') {$valw1='<a href="dbshowitem.php?id='.$dbey['id'].'" target="_blank">'; $valw2='</a>';} else {$valw1=''; $valw2='';}
switch ($outfmt) {
case 'webpage':
return '<tr>'.'<td>'.$key.'</td>'.'<td>'.$valw1.htmlspecialchars($val).$valw2.'</td>'.'</tr>';
break;
case 'webpage_list':
return '<td>'.$valw1.htmlspecialchars($val).$valw2.'</td>';
break;
case 'txt':
return $key.': '.$val."\n";
break;
case 'html':
return '<strong>'.$key.'</strong>'.': '.htmlspecialchars($val)."<br />\n";
break;
case 'csv':
$ous='';
if ($xnel>1) {$ous.=', ';}
return $ous.'"'.addslashes($val).'"';
break;
case 'xml':
return '<'.$key.'>'.htmlspecialchars($val).'</'.$key.'>'."\n";
break;
case 'json':
return '"'.addslashes($key).'"'.': '.'"'.addslashes($val).'"'."\n";
break;
}
}

?>
