<?
$module_id	= 10;
$module_name= "Tin tức";

//Declare prameter when insert data
$fs_table		= "products_step";
$field_id		= "prs_id";
$field_name		= "prs_title";
$break_page		= "{---break---}";

require_once("../../resource/security/security.php");

//Path save image
$fs_pathfile		= '../../../uploads/steps/';
$extension_list	= 'jpg,png,gif';
//Check user login...
checkLogged();
//Check access module...

$arrrayProducts = array( 0 => 'Chọn dự án');
$db_pro  = new db_query("SELECT * FROM products WHERE pro_active = 1");
while($rpro   = $db_pro->fetch()){
    $arrrayProducts[$rpro['pro_id']] = $rpro['pro_name'];
}
unset($db_pro);
?>