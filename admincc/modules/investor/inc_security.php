<?
$module_id	= 10;
$module_name= "Chủ đầu tư";

//Declare prameter when insert data
$fs_table		= "investors";
$field_id		= "inv_id";
$field_name		= "inv_name";
$break_page		= "{---break---}";

require_once("../../resource/security/security.php");

//Path save image
$fs_pathfile		= '../../../uploads/partner/';
$extension_list	= 'jpg,png,gif';
//Check user login...
checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

?>