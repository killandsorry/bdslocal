<?
$module_id 			= 13;
$module_name		= "Quản lý danh mục";

$fs_table			= "categories";
$id_field			= "cat_id";
$name_field			= "cat_name";
$fs_errorMsg		= "";
$fs_filepath		= "../../../pictures/category/";
$limit_size			= 750;
$extension_list	= "jpg,gif,png";
$add					= "add.php";
$listing				= "listing.php";
//check security...
require_once("../../resource/security/security.php");
//Check user login...
checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);


$array_config		= array("image"=>1,"upper"=>1,"order"=>1,"description"=>1);
?>