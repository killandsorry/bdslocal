<?
$module_id	= 10;
$module_name= "Tin tức";

//Declare prameter when insert data
$fs_table		= "news";
$field_id		= "new_id";
$field_name		= "new_name";
$break_page		= "{---break---}";

require_once("../../resource/security/security.php");

//Path save image
$fs_pathfile		= '../../../uploads/news/';
$extension_list	= 'jpg,png,gif';
//Check user login...
checkLogged();
//Check access module...

// danh mục việc làm
$arrayCat_vl   = array(
   0 => 'Chọn danh mục'
);
$db_cat_vl  = new db_query("SELECT * FROM categories WHERE cat_active = 1 AND cat_type = 'news'");
while($rc   = $db_cat_vl->fetch()){
   $arrayCat_vl[$rc['cat_id']] = $rc['cat_name'];
}
unset($db_cat_vl);

$arrrayProducts = array( 0 => 'Chọn dự án');
$db_pro  = new db_query("SELECT * FROM products WHERE pro_active = 1");
while($rpro   = $db_pro->fetch()){
    $arrrayProducts[$rpro['pro_id']] = $rpro['pro_name'];
}
unset($db_pro);
?>