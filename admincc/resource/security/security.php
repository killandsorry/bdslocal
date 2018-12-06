<?
session_start();
//error_reporting(0);
require_once("../../../classes/database.php");
require_once("../../../classes/form.php");
require_once("../../../functions/functions.php");
require_once("../../../functions/file_functions.php");
require_once("../../../functions/date_functions.php");
require_once("../../../functions/rewrite_functions.php");
require_once("../../../functions/resize_image.php");
require_once("../../../functions/translate.php");
//require_once("../../../functions/pagebreak.php");
require_once("../../../functions/template.php");
require_once("../../../classes/generate_form.php");
require_once("../../../classes/form.php");
require_once("../../../classes/upload.php");
require_once("../../../classes/menu.php");
require_once("../../../classes/user.php");
require_once("../../../classes/html_cleanup.php");
require_once("../../../classes/dissection.php");
require_once("grid.php");
require_once("../../resource/wysiwyg_editor/fckeditor.php");
require_once("functions.php");
require_once("template.php");
$admin_id 				= getValue("user_id","int","SESSION");
$lang_id	 				= getValue("lang_id","int","SESSION");


//phan khai bao bien dung trong admin
$fs_stype_css			= "../css/css.css";
$fs_template_css		= "../css/template.css";
$fs_border 				= "#f9f9f9";
$fs_bgtitle 			= "#DBE3F8";
$fs_imagepath 			= "../../resource/images/";
$fs_scriptpath 		= "../../resource/js/";
$wys_path				= "../../resource/wysiwyg_editor/";
$fs_denypath			= "../../error.php";
$wys_cssadd				= array();
$wys_cssadd				= "/css/all.css";
$sqlcategory 			= "";
//$fs_category			= checkAccessCategory();
$fs_is_in_adm			= 1;
//phan include file css

$load_header 			= '<link href="../../resource/css/css.css" rel="stylesheet" type="text/css">';
$load_header 			.= '<link href="../../resource/css/template.css" rel="stylesheet" type="text/css">';
$load_header 			.= '<link href="../../resource/css/grid.css" rel="stylesheet" type="text/css">';
$load_header 			.= '<link href="../../resource/css/thickbox.css" rel="stylesheet" type="text/css">';
$load_header 			.= '<link href="../../resource/css/calendar.css" rel="stylesheet" type="text/css">';
$load_header 			.= '<link href="../../resource/js/jwysiwyg/jquery.wysiwyg.css" rel="stylesheet" type="text/css">';
$load_header 			.= '<link href="../../resource/css/jquery.datepick.css" rel="stylesheet" type="text/css">';

//phan include file script
$load_header 			.= '<script language="javascript" src="../../resource/js/jquery-1.3.2.min.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/library.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/thickbox.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/calendar.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/tooltip.jquery.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/jquery.jeditable.mini.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/swfObject.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/jwysiwyg/jquery.wysiwyg.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/jquery.datepick.js"></script>';
$load_header 			.= '<script language="javascript" src="../../resource/js/jquery.datepick-vi.js"></script>';

$fs_change_bg			= 'onMouseOver="this.style.background=\'#DDF8CC\'" onMouseOut="this.style.background=\'#FEFEFE\'"';
//phan ngon ngu admin
$langAdmin 				= array();

$db_con = new db_query("SELECT 	con_currency,con_exchange from configuration WHERE con_lang_id=" . $lang_id);
if ($row=mysqli_fetch_array($db_con->result)){
	while (list($data_field, $data_value) = each($row)) {
		if (!is_int($data_field)){
			//tao ra cac bien config
			$$data_field = $data_value;
			//echo $data_field . "= $data_value <br>";
		}
	}
}
$db_con->close();
unset($db_con);

$array_value 		= get_type_categories();
$array_type_cat   = get_type_cat();								
$array_type 		= array(	"0"=>translate_text("Tin rao vặt")
									,"1"=>translate_text("Hàng khuyến mại")
									,"2"=>translate_text("tin quan trọng")
									,"3"=>translate_text("Hàng độc")
									,"4"=>translate_text("Hàng giá rẻ")	
									,"5"=>translate_text("Hàng sách tay")									
								);
								
$myDissection		=	new dissection();
$array_value 		=	$myDissection->array_type;
$arrayDefine		=	$myDissection->arrayDefine;
$array_prostatus    = getProStatus();

//phan khai bao lay tin tu tuyendung.com.vn

								
?>