<?
$module_id	= 16;
$module_name= "Blogs";

//Declare prameter when insert data
$fs_table		= "static_page";
$field_id		= "sta_id";
$field_name		= "sta_title";
$break_page		= "{---break---}";

require_once("../../resource/security/security.php");

//Path save image
$fs_pathfile		= '../../../upload/blog/';
$extension_list	= 'jpg,png,gif';

// danh mục việc làm
$arrayCat_vl   = array(
   0 => 'Chọn danh mục'
);
?>