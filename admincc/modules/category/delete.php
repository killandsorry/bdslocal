<?
require_once("inc_security.php");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "cat_id";

$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE cat_id =" . $record_id, __FILE__, DB_BLOG);
unset($db_del);
redirect($fs_redirect);

?>