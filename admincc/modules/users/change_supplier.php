<? 
include ("inc_security.php"); 
//check quyền them sua xoa

$record_id		=	getValue("record_id", 'int', 'POST', 0);
$sql				=	"";
$value			=	getValue("value", 'int', 'POST', 0);

$db_u	= new db_execute("UPDATE " . $fs_table . " SET use_supplier = " . $value . " WHERE  use_id=" . $record_id);
unset($db_u);
?>