<?
require_once("../../resource/security/security.php");

$module_id = 10;
//Check user login...
checkLogged();
//Check access module...

//Declare prameter when insert data
$fs_table	= "configuration";
$id_field	= "con_id";
//Cấu hình static
$arrStatic	= array ("Liên hệ"			=> "con_static_contact",
							"Cuối trang"		=> "con_static_footer",
							);
?>