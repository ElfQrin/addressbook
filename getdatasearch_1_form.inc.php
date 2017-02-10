<? if (!defined('IN_ENGINE')) {die('forbidden');}

$q=addslashes(trim($_REQUEST['q']));
if (strlen($q)>=$srchqminlen) {
$qusrch=' WHERE (LCASE(`artistlname`) LIKE "%'.strtolower($q).'%") OR (LCASE(`artistname`) LIKE "%'.strtolower($q).'%") OR (LCASE(`title`) LIKE "%'.strtolower($q).'%")'; # Search
}

?>