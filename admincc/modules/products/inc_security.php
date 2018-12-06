<?

//file inc_security trong module nào cũng phải có.
//includes file kiểm tra bảo mật và include các file cần thiết như class,function.
require_once("../../resource/security/security.php");
//$module_id	là id của module ở trong bảng module
$module_id	= 3;
//$module_name		là tiêu đề của module
$module_name= "Project";
//$fs_errorMsg		= "";
$img_path			= "../../../uploads/products/";
$limit_size			= 2000;
$extension_list	= "jpg,gif,png";
//Check user login... (gọi ra hàm kiểm tra bảo mật đăng nhập rồi hay chưa)
checkLogged();
//Check access module...(kiểm tra quyền xem có được phép truy cập module này hay không)
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table		= "products"; //tên bảng
$id_field		= "pro_id";//khóa chính trong bảng
$name_field		= "pro_name";//trường đại diện
$break_page		= "{---break---}";
// array tỉnh thành
$arrayCity      = array(0 => 'Chọn tỉnh thành');
$db_city    = new db_query("SELECT * FROM city WHERE cit_parent_id = 0");
while($rcity = $db_city->fetch()){
    $arrayCity[$rcity['cit_id']] = $rcity['cit_name'];
}
unset($db_city);

// array chủ đầu tư
$arrayInvestor = array(0 => 'Chọn chủ đầu tư');
$db_inves    = new db_query("SELECT * FROM investors");
while($rinves = $db_inves->fetch()){
    $arrayInvestor[$rinves['inv_id']] = $rinves['inv_name'];
}
unset($db_inves);

// array đơn vị thiets kê
$arrayDesign = array(0 => 'Chọn đơn vị thiết kế');
$db_design    = new db_query("SELECT * FROM designs");
while($rdesign = $db_design->fetch()){
    $arrayDesign[$rdesign['des_id']] = $rdesign['des_name'];
}
unset($db_design);

// array đơn vị thi công
$arrayConstruction = array(0 => 'Chọn đơn vị thi công');
$db_con    = new db_query("SELECT * FROM constructions");
while($rcon = $db_con->fetch()){
    $arrayConstruction[$rcon['con_id']] = $rcon['con_name'];
}
unset($db_con);

$arrayCat_vl   = array(
    0 => 'Chọn danh mục'
);
$db_cat_vl  = new db_query("SELECT * FROM categories WHERE cat_active = 1 AND cat_type = 'products' AND cat_parent_id > 0");
while($rc   = $db_cat_vl->fetch()){
    $arrayCat_vl[$rc['cat_id']] = $rc['cat_name'];
}
unset($db_cat_vl);


