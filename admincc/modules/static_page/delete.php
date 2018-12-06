<?
require_once("inc_security.php");
//check quyền them sua xoa
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","POST");
$field_id		= "blo_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);

$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE sta_id =" . $record_id, __FILE__, DB_BLOG);
unset($db_del);
redirect($fs_redirect);

?>