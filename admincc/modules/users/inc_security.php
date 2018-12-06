<?

//file inc_security trong module nào cũng phải có.
//includes file kiểm tra bảo mật và include các file cần thiết như class,function.
require_once("../../resource/security/security.php");
//$module_id	là id của module ở trong bảng module
$module_id	= 9;
//$module_name		là tiêu đề của module
$module_name= "Tin ";
//$fs_errorMsg		= "";
$img_path			= "../../../pictures/news_fullsize/";
$limit_size			= 2000;
$extension_list	= "jpg,gif,png";
//Check user login... (gọi ra hàm kiểm tra bảo mật đăng nhập rồi hay chưa)
checkLogged();
//Check access module...(kiểm tra quyền xem có được phép truy cập module này hay không)
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table		= "users"; //tên bảng
$id_field		= "use_id";//khóa chính trong bảng
$name_field		= "use_name";//trường đại diện
$break_page		= "{---break---}";
//$array_config		= array("image"=>1,"upper"=>1,"order"=>1,"description"=>1);
//Mảng array categories cha
$arrayCateoty		= array();
$array_pay  = array(
   0 => 'Tất cả',
   1 => 'Trả phí'    
);

$array_expires = array(
   0 => 'Tất cả',
   1 => 'Hết hạn trong tháng này'
);