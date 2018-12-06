<?
function checkSlowFunction($file,$line,$function_name){
	$function_name1 = $function_name . "_time";	
	global $function_analyze_array,$$function_name1;
	if (!isset($function_analyze_array)) $function_analyze_array = array();
	if(!isset($$function_name1)){
		$$function_name1 = microtime_float();	
	}else{
		$time = microtime_float() - $$function_name1;
		$arr = array("file" => $file,"line" => $line,"function" => $function_name,"time" => $time);
		$function_analyze_array[$function_name][] = $arr;				
		
	} $time = microtime_float();	
	$arr = array("file" => $file,"line" => $line,"function" => $function_name,"time" => $time);
	
}
function detectSpecialWord($string){
	$string 			= mb_strtolower($string,'UTF-8');
	$arrayString 	= explode(" ",$string);
	$arrayNew 		= array();
	foreach($arrayString as $word){
 		if(preg_match("/[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/i",$word,$matches)) continue;
 		if(strlen($word) <= 3) continue;
		$arrayNew[$word] = BuildTrigrams($word);
	}
	return $arrayNew;
}
function crateUrlToken($arrayParam = array(),$return = 1){
	$arrayParam["time"] = time();
	$string = "token=" . tokenEncode(json_encode($arrayParam)); 
	if($return) $string .= "&urlreturn=" . createUrlReturn($_SERVER["REQUEST_URI"]);
	return $string;
}
function getUrlReturn($default_url = ""){
	$urlreturn = base64_url_decode(getValue("urlreturn","str","GET",base64_url_encode($default_url)));
	return $urlreturn;
}
function createUrlReturn($url, $ignore_from_url = 0){
	if($ignore_from_url){
		$urlreturn = base64_url_encode($url);
	}else{
		$urlreturn = getValue("urlreturn","str","GET",base64_url_encode($url));	
	}
	return $urlreturn;
}
function decodeUrlToken(){
	$token = getValue("token","str","GET","");
	if($token == "") return;
	$token = json_decode(tokenDecode($token),true);
	if(is_array($token)){
		$time = isset($token["time"]) ? $token["time"] : 0;
		if((time()-$time) > (3600*6)) exit("Loi token");
		foreach($token as $key => $val) $_GET[$key] = $val;
	}
}
define("KEY_TOKEN","bcb88b7e103a0cd8b22263051cef08bc55abe029fdebae5e1d456e2ffb2a00a3");
function tokenEncode($plaintext){
	$key = "fdsljfldsjlfjlsdjlf";
	$checksum = md5($plaintext . "|" . $key);
	$arr = array("checksum" => $checksum,"plaintext" => $plaintext);
	return base64_url_encode(json_encode($arr));
}

function tokenDecode($ciphertext){
	$arr = json_decode(base64_url_decode($ciphertext),true);
	$key = "fdsljfldsjlfjlsdjlf";
	$checksum = isset($arr["checksum"]) ? $arr["checksum"] : '';
	$plaintext = isset($arr["plaintext"]) ? $arr["plaintext"] : '';
	if($checksum == md5($plaintext . "|" . $key)){
		return $plaintext;
	}else{
		return '';
	}
}
/**
 * Ham kich hoat user thanh toan tien
 */
function activeUserPayment($user_id,$admin_id = 0,$expire = 0){
	$user_id = intval($user_id);
	$total_record = 0;
	//tạo bảng mới riêng cho user đó
	$db_ex = new db_execute("CREATE TABLE IF NOT EXISTS user_products_" . $user_id . " LIKE user_products;");
	$total_record += $db_ex->total;
	unset($db_ex);
	//đẩy dữ liệu sang bảng mới
	$db_ex = new db_execute("INSERT IGNORE INTO user_products_" . $user_id . " SELECT * FROM user_products WHERE usp_use_parent_id = " . $user_id .";");
	$total_record += $db_ex->total;
	unset($db_ex);
	$db_ex = new db_execute("CREATE TABLE IF NOT EXISTS user_orders_" . $user_id . " LIKE user_orders;");
	$total_record += $db_ex->total;
	unset($db_ex);
	$db_ex = new db_execute("INSERT IGNORE INTO user_orders_" . $user_id . " SELECT * FROM user_orders WHERE uso_use_parent_id = " . $user_id .";");
	$total_record += $db_ex->total;
	unset($db_ex);
	$db_ex = new db_execute("CREATE TABLE IF NOT EXISTS user_stock_" . $user_id . " LIKE user_stock;");
	$total_record += $db_ex->total;
	unset($db_ex);
	$db_ex = new db_execute("INSERT IGNORE INTO user_stock_" . $user_id . " SELECT * FROM user_stock WHERE uss_use_parent_id = " . $user_id .";");
	$total_record += $db_ex->total;
	unset($db_ex);
	$db_ex = new db_execute("INSERT IGNORE INTO logs_active_payment(lap_admin_id,lap_use_parent_id,lap_date,lap_expire)
									 VALUES(" . $admin_id . "," . $user_id . "," . time() . "," . $expire . ")");
	$total_record += $db_ex->total;
	unset($db_ex);
	return $total_record;
}

function getHeightImg($thumb_width, $src_width, $src_height){
	if($src_width <= 0) return $thumb_width;
	return round(($thumb_width * $src_height) / $src_width);
}
function getImageThumb($filename, $maxWidth = 0, $maxHeight = 0){
	if($maxWidth < 50) $maxWidth = 50;
	if($maxHeight < 100) $maxHeight = 100;
	if($filename == "") return "/images/no_photo_x_small.gif";
	return "/pictures/thumb/" . $maxWidth . "x" . $maxHeight . "/" . getPathDateTimeImg($filename);
}
function getPathDateTimeImg($filename, $pre_path = ""){
	$filename = @end(explode("/", $filename));
	$time = intval(preg_replace("/[^0-9]/i","",$filename));
	if($time > time()) $time = time();
	return $pre_path . date("Y/m/", $time) . $filename;
}
function base64_url_encode($input){
	return strtr(base64_encode($input), '+/=', '_,-');
}
function base64_url_decode($input) {
	return base64_decode(strtr($input, '_,-', '+/='));
}
function get_type_categories(){
	$array_value 		= array("thuoc" => translate_text("Thuốc")//
										,"news" => translate_text("Tin tức bài viết")
										,"sale" => translate_text("Thuốc bán")
								);
	return $array_value;
}

function get_type_cat(){
	$array_value 		= array("blog" => translate_text("Blog")//
										,"help" => translate_text("Hướng dẫn")
								);
	return $array_value;
}

function removeSpecialChar($string){
	 //$string = removeAccent($string);
	 $string  =  (preg_replace("/[^A-Za-z0-9àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴÈÉẸẺẼÊỀẾỆỂỄÌÍỊỈĨÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠÙÚỤỦŨƯỪỨỰỬỮỲÝỴỶỸĐĐ]/i","-",$string)); // khong dau
	 $string = preg_replace('/-+/', '-', $string);
	 $string = str_replace('-', ' ', $string);
	 return trim($string);
}

function getProStatus (){
    $arr = array(
        0 => 'Chọn',
        1 => 'Đang bàn giao nhà',
        2 => 'Sắp bàn giao nhà',
        3 => 'Đã bàn giao nhà'
    );

    return $arr;
}
function replaceTag($content,$array=array()){

	if(count($array)>0){
		foreach($array as $key=>$value){
			$value = trim($value);
			if($value!=''){
				//echo $value. chr(13);
				//$content = @preg_replace("#" . $value . "#Usi","<b>$0</b>",$content);
				//echo $content;
			}
		}
	}
	return $content;
}
function array_currency(){
	$arrReturn	= array(0 => "USD", 1 => "EUR");
	return $arrReturn;
}

function array_language(){
	$db_language	= new db_query("SELECT * FROM languages ORDER BY lang_id ASC");
	$arrReturn		= array();
	while($row = mysqli_fetch_array($db_language->result)){
		$arrReturn[$row["lang_id"]] = array($row["lang_code"], $row["lang_name"]);
	}
	return $arrReturn;
}

function callback($buffer){
	$str		= array(chr(9));
	$buffer	= str_replace($str, "", $buffer);
	$buffer	= str_replace("  ", " ", $buffer);
	$buffer	= str_replace("  ", " ", $buffer);
	$buffer	= str_replace("  ", " ", $buffer);
	$buffer	= str_replace("  ", " ", $buffer);
	$buffer	= str_replace("  ", " ", $buffer);
	$buffer	= str_replace("  ", " ", $buffer);
	return $buffer;
}

function responseData($data){
	$etag 	= hash("sha256",$data . json_encode($_POST));
	saveLog1("log_cache.cfn", $data);
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", 112233456)." GMT");
	header("Etag: " . $etag);
	header("Accept-Ranges: bytes");
	//header('Content-Type: application/json');
	if (trim(@$_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
		 saveLog1("header.cfn", @$_SERVER['HTTP_IF_NONE_MATCH'] ."\n" . @$_SERVER['HTTP_IF_MODIFIED_SINCE']);
	    header("HTTP/1.1 304 Not Modified");
	    exit;
	}
	echo $data;
	flush();
	ob_end_flush();
	exit();
}

function saveLog1($filename, $content){

	$log_path     =   $_SERVER["DOCUMENT_ROOT"] . "/logs/";
	$handle       =   @fopen($log_path . $filename . ".cfn", "a");
	//Neu handle chua co mo thêm ../
	if (!$handle) $handle = @fopen($log_path . $filename . ".cfn", "a");
	//Neu ko mo dc lan 2 thi exit luon
	if (!$handle) exit();
	fwrite($handle, date("d/m/Y h:i:s A") . " " . @$_SERVER["REQUEST_URI"] . "\n" . $content . "\n");
	fclose($handle);

}

function check_email_address($email) {
	//First, we check that there's one @ symbol, and that the lengths are right
	if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)){
		//Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	//Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for($i = 0; $i < sizeof($local_array); $i++){
		if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])){
			return false;
		}
	}
	if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])){
	//Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if(sizeof($domain_array) < 2){
			return false; // Not enough parts to domain
		}
		for($i = 0; $i < sizeof($domain_array); $i++){
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])){
				return false;
			}
		}
	}
	return true;
}

function check_session_security($security_code){
	$return = 1;
	if(!isset($_SESSION["session_security_code"])) $_SESSION["session_security_code"] = generate_security_code();
	if($security_code != $_SESSION["session_security_code"]){
		$return = 0;
	}
	// Reset lại session security code
	$_SESSION["session_security_code"] = generate_security_code();
	return $return;
}

function cut_string($str, $length, $char=" ..."){
	//Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
	$strlen	= mb_strlen($str, "UTF-8");
	if($strlen <= $length) return $str;

	//Cắt chiều dài chuỗi $str tới đoạn cần lấy
	$substr	= mb_substr($str, 0, $length, "UTF-8");
	if(mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;

	//Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
	$strPoint= mb_strrpos($substr, " ", "UTF-8");

	//Return string
	if($strPoint < $length - 20) return $substr . $char;
	else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
}

function format_number($number, $edit=0, $intval = 0){
	if($intval) $number = intval($number);
	if($edit == 0){
		$return	= number_format($number, 2, ".", ".");
		if(intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", ".");
		elseif(intval(substr($return, -1, 1)) == 0) $return = number_format($number, 1, ".", ".");
		return $return;
	}
	else{
		$return	= number_format($number, 2, ".", "");
		if(intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", "");
		return $return;
	}
}

function parse_type_number($vl = 0){
   if($vl == '') return '';
   if($vl <= 0) return 0;
   $new_vl  = str_replace('.', '', $vl);
   return intval($new_vl);
}

function format_currency($value = ""){
	$str		=	$value;
	if($value != ""){
		$str		=	number_format($value,0,"",",");
	}
	return $str;
}

function generate_array_variable($variable){
	$list			= tdt($variable);
	$arrTemp		= explode("{-break-}", $list);
	$arrReturn	= array();
	for($i=0; $i<count($arrTemp); $i++) $arrReturn[$i] = trim($arrTemp[$i]);
	return $arrReturn;
}

function generate_security_code(){
	$code	= rand(1000, 9999);
	return $code;
}

function getURL($serverName=0, $scriptName=0, $fileName=1, $queryString=1, $varDenied=''){
	$url	 = '';
	$slash = '/';
	if($scriptName != 0)$slash	= "";
	if($serverName != 0){
		if(isset($_SERVER['SERVER_NAME'])){
			$url .= 'http://' . $_SERVER['SERVER_NAME'];
			if(isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
			$url .= $slash;
		}
	}
	if($scriptName != 0){
		if(isset($_SERVER['SCRIPT_NAME']))	$url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}
	if($fileName	!= 0){
		if(isset($_SERVER['SCRIPT_NAME']))	$url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}
	if($queryString!= 0){
		$url .= '?';
		reset($_GET);
		$i = 0;
		if($varDenied != ''){
			$arrVarDenied = explode('|', $varDenied);
			while(list($k, $v) = each($_GET)){
				if(array_search($k, $arrVarDenied) === false){
					$i++;
					if($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
					else $url .= $k . '=' . @urlencode($v);
				}
			}
		}
		else{
			while(list($k, $v) = each($_GET)){
				$i++;
				if($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
				else $url .= $k . '=' . @urlencode($v);
			}
		}
	}
	$url = str_replace('"', '&quot;', strval($url));
	return $url;
}

function getValue($value_name, $data_type = "int", $method = "GET", $default_value = 0, $advance = 0){
	$value = $default_value;
	switch($method){
		case "GET": if(isset($_GET[$value_name])) $value = $_GET[$value_name]; break;
		case "POST": if(isset($_POST[$value_name])) $value = $_POST[$value_name]; break;
		case "COOKIE": if(isset($_COOKIE[$value_name])) $value = $_COOKIE[$value_name]; break;
		case "SESSION": if(isset($_SESSION[$value_name])) $value = $_SESSION[$value_name]; break;
		default: if(isset($_GET[$value_name])) $value = $_GET[$value_name]; break;
	}
	/**
	 * Edit 26/03/2014
	 * - Sửa lại để không dính lỗi trên PHP 5.4 với hàm strval khi get arr
	 */
	$data_type = trim(strtolower($data_type));
	switch($data_type)
	{
		case 'int':
         $value = str_replace('.', '', $value);
			$returnValue = intval($value);
			break;
		case 'str':
			$returnValue = strval($value);
			break;
		case 'flo':
			$returnValue = floatval($value);
			break;
		case 'dbl':
			$returnValue = doubleval($value);
			break;
		case 'arr':
			$returnValue = $value;
			break;
		default:
			//Nếu mặc định ko truyền data_type thì là kiểu int
			$returnValue = intval($value);
			break;
	}
	//Check xem có cần format giá trị trả về hay không??
	if($advance != 0 && is_string($returnValue)){
		switch($advance){
			case 1:
				$returnValue = replaceMQ($returnValue);
				break;
			case 2:
				$returnValue = htmlspecialbo($returnValue);
				break;
		}
	}
	//Do số quá lớn nên phải kiểm tra trước khi trả về giá trị
	if(($data_type != "str") && !is_array($returnValue) && (strval($returnValue) == "INF")) return 0;
	return $returnValue;
	/*
     $valueArray	= array("int" => intval($value), "str" => trim(strval($value)), "flo" => floatval($value), "dbl" => doubleval($value), "arr" => $value);
     foreach($valueArray as $key => $returnValue){
         if($data_type == $key){
             if($advance != 0){
                 switch($advance){
                     case 1:
                         $returnValue = replaceMQ($returnValue);
                         break;
                     case 2:
                         $returnValue = htmlspecialbo($returnValue);
                         break;
                 }
             }
             //Do số quá lớn nên phải kiểm tra trước khi trả về giá trị
             if((strval($returnValue) == "INF") && ($data_type != "str")) return 0;
             return $returnValue;
             break;
         }
     }
     return (intval($value));
    */
}

function get_server_name(){
	$server = $_SERVER['SERVER_NAME'];
	if(strpos($server, "asiaqueentour.com") !== false) return "http://www.asiaqueentour.com";
	else return "http://" . $server . ":" . $_SERVER['SERVER_PORT'];
}

function htmlspecialbo($str){
	$arrDenied	= array('<', '>', '\"', '"');
	$arrReplace	= array('&lt;', '&gt;', '&quot;', '&quot;');
	$str = str_replace($arrDenied, $arrReplace, $str);
	return $str;
}

function javascript_writer($str){
	$mytextencode = "";
	for ($i=0;$i<strlen($str);$i++){
		$mytextencode .= ord(substr($str,$i,1)) . ",";
	}
	if ($mytextencode!="") $mytextencode .= "32";
	return "<script language='javascript'>document.write(String.fromCharCode(" . $mytextencode . "));</script>";
}

function lang_path(){
	global $lang_id;
	global $array_lang;
	global $con_root_path;
	$default_lang = 1;
	$path	= ($lang_id == $default_lang) ? $con_root_path : $con_root_path . $array_lang[$lang_id][0] . "/";
	return $path;
}

function microtime_float(){
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

function random(){
	$rand_value = "";
	$rand_value.= rand(1000,9999);
	$rand_value.= chr(rand(65,90));
	$rand_value.= rand(1000,9999);
	$rand_value.= chr(rand(97,122));
	$rand_value.= rand(1000,9999);
	$rand_value.= chr(rand(97,122));
	$rand_value.= rand(1000,9999);
	return $rand_value;
}

function redirect($url){
	$url	= htmlspecialbo($url);
	echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
	exit();
}

function removeAccent($mystring){
	$marTViet=array(
		// Chữ thường
		"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
		"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ","Đ","'",
		// Chữ hoa
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ","Đ","'"
		);
	$marKoDau=array(
		/// Chữ thường
		"a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d","D","",
		//Chữ hoa
		"A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D","D","",
		);
	return str_replace($marTViet, $marKoDau, $mystring);
}

function removeHTML($string){
	$string = preg_replace ('/<script.*?\>.*?<\/script>/si', ' ', $string);
	$string = preg_replace ('/<style.*?\>.*?<\/style>/si', ' ', $string);
	$string = preg_replace ('/<.*?\>/si', ' ', $string);
	$string = str_replace ('&nbsp;', ' ', $string);
	$string = mb_convert_encoding($string, "UTF-8", "UTF-8");
	$string = str_replace (array(chr(9),chr(10),chr(13)), ' ', $string);
	for($i = 0; $i <= 5; $i++) $string = str_replace ('  ', ' ', $string);
	return $string;
}

function removeLink($string){
	$string = preg_replace ('/<a.*?\>/si', '', $string);
	$string = preg_replace ('/<\/a>/si', '', $string);
	return $string;
}

function replaceFCK($string, $type=0){
	$array_fck	= array ("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Igrave;", "&Iacute;", "&Icirc;",
								"&Iuml;", "&ETH;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ugrave;", "&Uacute;", "&Yacute;", "&agrave;",
								"&aacute;", "&acirc;", "&atilde;", "&egrave;", "&eacute;", "&ecirc;", "&igrave;", "&iacute;", "&ograve;", "&oacute;",
								"&ocirc;", "&otilde;", "&ugrave;", "&uacute;", "&ucirc;", "&yacute;",
								);
	$array_text	= array ("À", "Á", "Â", "Ã", "È", "É", "Ê", "Ì", "Í", "Î",
								"Ï", "Ð", "Ò", "Ó", "Ô", "Õ", "Ù", "Ú", "Ý", "à",
								"á", "â", "ã", "è", "é", "ê", "ì", "í", "ò", "ó",
								"ô", "õ", "ù", "ú", "û", "ý",
								);
	if($type == 1) $string = str_replace($array_fck, $array_text, $string);
	else $string = str_replace($array_text, $array_fck, $string);
	return $string;
}

function replaceJS($text){
	$arr_str = array("\'", "'", '"', "&#39", "&#39;", chr(10), chr(13), "\n");
	$arr_rep = array(" ", " ", '&quot;', " ", " ", " ", " ");
	$text		= str_replace($arr_str, $arr_rep, $text);
	$text		= str_replace("    ", " ", $text);
	$text		= str_replace("   ", " ", $text);
	$text		= str_replace("  ", " ", $text);
	return $text;
}

function replace_keyword_search($keyword, $lower=1){
	if($lower == 1) $keyword	= mb_strtolower($keyword, "UTF-8");
	$keyword	= replaceMQ($keyword);
	$arrRep	= array("'", '"', "-", "+", "=", "*", "?", "/", "!", "~", "#", "@", "%", "$", "^", "&", "(", ")", ";", ":", "\\", ".", ",", "[", "]", "{", "}", "‘", "’", '“', '”');
	$keyword	= str_replace($arrRep, " ", $keyword);
	$keyword	= str_replace("  ", " ", $keyword);
	$keyword	= str_replace("  ", " ", $keyword);
	return $keyword;
}

function replaceMQ($text){
	$text	= str_replace("\'", "'", $text);
	$text	= str_replace("'", "''", $text);
	return $text;
}

function remove_magic_quote($str){
	$str = str_replace("\'", "'", $str);
	$str = str_replace("\&quot;", "&quot;", $str);
	$str = str_replace("\\\\", "\\", $str);
	return $str;
}

function tdt($variable){
	global $lang_display;
	if (isset($lang_display[$variable])){
		if (trim($lang_display[$variable]) == ""){
			return "#" . $variable . "#";
		}
		else{
			$arrStr	= array("\\\\'", '\"');
			$arrRep	= array("\\'", '"');
			return str_replace($arrStr, $arrRep, $lang_display[$variable]);
		}
	}
	else{
		return "_@" . $variable . "@_";
	}
}

function generate_star($value = 1, $width = 19){
	$value	=	intval($value);
	$width	=	intval($width);
	$str	=	'';
	$str	.=	'<span class="rateStar" style="background: url(\'/themes/v1/images/rating-star-'	.	$width	.	'.png\') no-repeat scroll 0 0 transparent; display: inline-block; height: '	.	$width	.	'px; width: '	.	($value*$width)	.	'px; background-position: 0px '	.	($value - 1)*(-$width)	.	'px;"></span>';
	return $str;
}


function lost_pwd_mail($email) {
	$link			=	"";
	$reset_pwd	=	"luongcaocao";
	$db_user		=	new db_query("SELECT use_id, use_password FROM users WHERE use_email = '" . $email . "'");
	if($user		=	mysqli_fetch_assoc($db_user->result)) {
		$checksum		=	md5($reset_pwd . "/" . $user['use_id'] . "/" . $user["use_password"]);
		$link		= 'home/reset_password.php?u=' . $user['use_id'] . '&validator=' . $checksum;
	}
	unset($db_user);

	$content 	= "";
	if($link == "") {
		$content .= "Xin chào, <br />";
		$content .= "Bạn hoặc ai đó vừa sử dụng địa chỉ email này để yêu cầu lấy lại mật khẩu trên trang luongcao <br />";
		$content .= "Tuy nhiên, địa chỉ email bạn cung cấp không tồn tại trong cơ sở dữ liệu của luongcao<br />";
		$content .= "Bạn vui lòng cung cấp chính xác địa chỉ email để nhận lại mật khẩu.<br />";
		$content .= "<br />Thân!<br />";
		$content .= "<span stype='color: #999'>luongcao - Chuyên trang tuyển dụng việc làm hấp dẫn, lương cao.</span>";
	} else {
		//$content .= "<div style='border:3px double #94c7ff; padding: 10px; line-height: 19px; color: #444'>";
		$content .= "Xin chào, <br />";
		$content .= "Bạn hoặc ai đó vừa sử dụng địa chỉ email này để yêu cầu lấy lại mật khẩu trên trang luongcao <br />";
		$content .= "Nếu chính xác là bạn thì mời xác nhận việc yêu cầu gửi lại mật khẩu theo đường link sau đây: <br />";
		$content .= "http://luongcao.com/" . $link;
		$content .= "<br /><br />Thân!<br />";
		$content .= "<span stype='color: #999'>luongcao - Chuyên trang tuyển dụng việc làm hấp dẫn, lương cao.</span>";
		//$content	.=	"</div>";
	}

	$send		= send_mailer_spam($email, "Xác nhận yêu cầu lấy lại mật khẩu trên trang luongcao", $content);

	if($send) {
		return 1;
	} else {
		return 0;
	}
}

function new_password_mail($email, $new_password) {
	$content	  =  "";
	$content  .=  "Mật khẩu mới của bạn là: <b>" . $new_password . "</b><br />";
	$content  .=  "Vui lòng đổi lại mật khẩu ngay khi đăng nhập thành công.<br />";
	$content  .= "<br /><br />Thân!<br />";
	$content  .= "<span stype='color: #999'>luongcao - Chuyên trang tuyển dụng việc làm hấp dẫn, lương cao.</span>";
	if(send_mailer_spam($email, "Mật khẩu mới trên trang luongcao", $content)) {
		return true;
	} else {
		return false;
	}
}

function register_success_mail($email, $uid) {
	$link 		=	"";
	$db_user		=	new db_query("SELECT use_id, use_password,use_email_active FROM users WHERE use_email = '" . $email . "'");
	if($user		=	mysqli_fetch_assoc($db_user->result)) {
		$checksum		=	md5($user['use_email_active'] . "/" . $user['use_id'] . "/" . $user["use_password"]);
		$link		= 'home/verify_acccount.php?u=' . $user['use_id'] . '&validator=' . $checksum;
	}
	unset($db_user);
	$content  = "";
	$content .= "Bạn đã đăng ký thành công tài khoản trên trang luongcao <br />";
	$content .= "Mặc định, tài khoản của bạn có thể sử dụng ngay các dịch vụ trên site của chúng tôi.<br />";
	$content .= "Tuy nhiên, để đăng tin tuyển dụng không giới hạn, bạn cần phải xác thực tài khoản của bạn theo đường dẫn sau:<br />";
	$content .= "http://luongcao.com/" . $link . "<br/>";
	$content .= "Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi<br />";
	$content .= "<br /><br />Thân!<br />";
	$content .= "<span stype='color: #999'>luongcao - Chuyên trang tuyển dụng việc làm hấp dẫn, lương cao.</span>";
	if(send_mailer_spam($email, "Xác thực tài khoản - Chào mừng bạn đến với luongcao", $content)) {
		return true;
	} else {
		return false;
	}
}

function get_navigate($array = array()){

	global $iData,$arrayCatNews,$arrayCatChild,$iCat;

	$iCat		= getValue("iCat");
	$iNew		= getValue("iData");
	$arrayRetun	=	array();
	$arrayQuery	=	array();

	$i	=	0;
	if($iCat > 0){
		$cat_parent	= 0;

		if(isset($arrayCatNews[$iCat])){
			$cat_parent	= $arrayCatNews[$iCat]['cat_parent_id'];
			if($cat_parent > 0 && isset($arrayCatChild[$cat_parent][$iCat])){
				$param = array("cat_id" => $cat_parent, 'cat_name' => $arrayCatNews[$cat_parent]['cat_name']);
				$link_category	=	rewrite_cat_news($param);
				$arrayRetun[$i]["name"]	= $arrayCatNews[$cat_parent]['cat_name'];
				$arrayRetun[$i]["link"]	= $link_category;
				$i++;
			}

			$param = array("cat_id" => $iCat, 'cat_name' => $arrayCatNews[$iCat]['cat_name']);
			$link_category	=	rewrite_cat_news($param);
			$arrayRetun[$i]["name"]	= $arrayCatNews[$iCat]['cat_name'];
			$arrayRetun[$i]["link"]	= $link_category;
			$i++;
		}
	}
	if($iData > 0){
		$db_cla	= new db_query(" SELECT *
										  FROM news
										  WHERE new_id = " . $iData, __FILE__ . " Line: " . __LINE__);
		if($rdata	= mysqli_fetch_assoc($db_cla->result)){
			$link		= rewrite_url_news($rdata);
			$arrayRetun[$i]["name"]	= html_entity_decode($rdata["new_title"], ENT_QUOTES, 'UTF-8');
			$arrayRetun[$i]["link"]	= $link;
		}
	}
	return $arrayRetun;
}


function format_login_phone($phone)
{

   $phone = str_replace('+84', '0', $phone);
   $phone  = str_replace(array(' ', '.', ',', '-'), '', $phone);
   $phone = preg_replace("/[^A-Za-z0-9 ]/", '', $phone);
   
   //Check xem có bắt đầu bằng số 0?
   if(substr($phone,0,1) == '0'){
      //09 thì là 10 số --- 01 thì là 11 số
      if(
      (substr($phone, 0, 2) == '09' && strlen($phone) == 10)
      || (substr($phone, 0, 2) == '01' && strlen($phone) == 11)
      )
      {
         return $phone;
      }
   }
   return false;
}

function search_user_product($table = '', $keyword = ''){
   global $admin_id, $branch_id;
   $data = array();
   if($table   == '') return $data;
   
   $sqlWhere  = '';
   if($keyword != ''){
      $sqlWhere = " AND usp_pro_name LIKE '%". replaceMQ($keyword) ."%'";
   }
   
   $db_products = new db_query("SELECT * FROM " . $table . " 
                                 WHERE usp_use_parent_id = " . intval($admin_id) . " 
                                       AND usp_branch_id = " . $branch_id . $sqlWhere . " 
                                       AND usp_active = 1
                                 ORDER BY usp_alias ASC LIMIT 50");
   while($row  = mysqli_fetch_assoc($db_products->result)){
      $data[$row['usp_id']] = $row;
   }
   unset($db_products);
   return $data;
}

function search_data_product($table = '', $keyword = '', $array_not_in = array()){
   $data = array();
   if($table == '') return $data;
   
   $sqlWhere  = "";
   if($keyword != ''){
      $sqlWhere = " AND dat_name LIKE '%". replaceMQ($keyword) ."%'";
   }
   if(!empty($array_not_in)){
      $sqlWhere   .= " AND dat_id NOT IN(". implode(',', $array_not_in) .") ";
   }
   
   $db_products = new db_query("SELECT * FROM datas
                                 WHERE 1 " . $sqlWhere . " AND dat_active = 1 LIMIT 50");
   while($row  = mysqli_fetch_assoc($db_products->result)){               
      $data[$row['dat_id']] = $row;
   }
   unset($db_products);
   
   return $data;
}


function deny_error($permission = 0){
   global $arrayUserRight, $admin_id;
   
   if($permission <= 0) return '';
   
   $userInfo   = array();
   $db_user = new db_query("SELECT * FROM users WHERE use_id = " . intval($admin_id) . " LIMIT 1");
   if($row     = mysqli_fetch_assoc($db_user->result)){
      $userInfo = $row;
   }else{
      return '';
   }
   unset($db_user);
   
   $html = '
      <div class="expires">
         <h3>Truy cập chức năng <b>'. $arrayUserRight[$permission]['name'] .'</b> bị từ chối: </h3>
         <p style="color: #f00;">
            Tài khoản của bạn không có quyền sử dụng chức năng này. Vui lòng liên hệ với: <br><b>'. $userInfo['use_fullname'] .'</b> Số ĐT: <b>'. $userInfo['use_phone'] .'</b><br>
            Để yêu cầu cấp quyền sử dụng tính năng: <b><i>('. $permission .') </i>'. $arrayUserRight[$permission]['name'] .'</b>
         </p>
         <br>Cảm ơn bạn đã tin tưởng và sử dụng phần mềm của chúng tôi!
      </div>
   ';
   
   return $html;
}

/**
 * Check os platform
 * 
 * 0 : desktop
 * 1 : andoird
 * 2 : winphone
 * 3 : ios
 */
function checkOS($u_agent = ''){
   $os = 0;
   if($u_agent == '') return 0;   
   $agent   = strtolower($u_agent);
   if(strpos($agent,"iphone") !== false || strpos($agent,"ipad")  !== false){
      $os = 3;
      return $os;
   }else if(strpos($agent,"windows phone")  !== false){
      $os = 2;
      return $os;
   }else if(strpos($agent,"android")  !== false){
      $os = 1;
      return $os;         
   }
   return $os;   
}


/**
 * 
 * Function generate function url filter sale list
 */
function generate_url_sale_list_filter($array_get = array(), $array_filter = array(), $key_filter = '', $url = ''){
 
   $new_url = $url;
   if(empty($array_filter) || $key_filter == '') return $new_url;
   
   $i = 0;
   foreach($array_filter as $field){
      if($field != $key_filter){
         unset($array_get[$field]);
         $i++;
         continue;
      } 
      
      if(!isset($array_get[$key_filter])){
         $array_get[$key_filter] = 'asc';      
      }else{
         if($array_get[$key_filter] == 'asc'){
            $array_get[$key_filter] = 'desc';
         }else{
            $array_get[$key_filter] = 'asc';
         }
      }
      $i++;
   }
   
   if(!empty($array_get)){
      $a = array();
      foreach($array_get as $k => $v){
         $a[] = $k . '=' . $v;
      }
      return  $url . '?' . implode('&', $a);
   }
   
   return $new_url;
}


/**
 * 
 * Function generate function url filter sale list
 */
function generate_url_sale_list_search($array_get = array(), $key_filter = '', $value = '', $url = ''){
 
   $new_url = $url;
   if($key_filter == '') return $new_url;
   
   switch($key_filter){
      case 'date':
         $date   = date('Y-m-d', $value);
         $array_get['start_fill_date'] = $date; 
         $array_get['end_fill_date'] = $date;
         break;
      case 'user':
         $array_get['user_id'] = $value;
         break;
   }
   
   if(!empty($array_get)){
      $a = array();
      foreach($array_get as $k => $v){
         $a[] = $k . '=' . $v;
      }
      return  $url . '?' . implode('&', $a);
   }
   
   return $new_url;
}

/**
 * Ham tinh thoi gian da qua ra phut
 */
function countTime($timein = 0){
	$timeCount		= time() - $timein;
	// nếu time > 30 ngày thì trả về số chính xác luôn
	if($timeCount > (30 * 86400)) return 'Lúc: ' . date('H:i - d/m/Y', $timein);

	$timeFday		= mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
	// neeus time < time đầu ngày thì hiển thị theo ngày

	// nếu time là trong ngày thì tính theo h hoặc phút
	if($timein > $timeFday){
		if($timeCount / 60 > 59){
			return round($timeCount / 3600) . ' giờ trước';
		}else{
			$phut	= round($timeCount / 60);
			if($phut < 5) return 'vài giây trước';
			return $phut . ' phút trước';
		}
	}else{
		if($timein < $timeFday && $timein >= ($timeFday - 86400)){
			return 'hôm qua';
		}else{
			return round($timeCount / 86400) . ' ngày trước';
		}
	}
}

/**
 * hàm tạo barcode
 * truyền vào 12 ký tự
 * return 13 ký tự
 */
function generate_me_barcode($ean){
   
   if(strlen($ean) != 12) return 0;
   $ean=(string)$ean;
   $even=true; $esum=0; $osum=0;
   for ($i=strlen($ean)-1;$i>=0;$i--){
      if ($even) $esum+=$ean[$i];	else $osum+=$ean[$i];
      $even=!$even;
   }
   $check_sum   = (10-((3*$esum+$osum)%10))%10;
   return $ean . $check_sum;
}

/**
 * hàm hiển thị barcde
 */
function show_barcode($barcode ,$mebarcode){
   if($barcode != '' && $barcode != 0) return $barcode;
   return $mebarcode;
}


function show_type_login($t = 0){
   $type_name = '';
   switch($t){
      case 0:
         $type_name = '<span class="status_btn bg_acc">Thường</span>';
         break;
      case 1:
         $type_name = '<span class="status_btn bg_mov">Face login</span>';
         break;
      case 2:
         $type_name = '<span class="status_btn bg_can">Debug login</span>';
         break;
   }
   
   return $type_name;
}


/**
 * functin check unit
 * array(
 *    usp_unit_import =>
 *    usp_unit
 =>  * )
 */
function check_unit($data = array()){
   $unit_import = isset($data['usp_unit_import'])? intval($data['usp_unit_import']) : 0;
   $unit = isset($data['usp_unit'])? intval($data['usp_unit']) : 0;
   $specifi = isset($data['usp_specifi'])? intval($data['usp_specifi']) :  1;
   
   if($unit > 0 && $unit_import == 0) return 0;
   if($unit == 0) return 0;
   if($unit_import == 0 && $unit == 0) return 0;
   if($unit_import == 0) return 0;
   if($unit_import == $unit && $specifi > 1) return 0;
   
   return 1;
}

/**
 * Function start time on site
 */
function start_time_onsite(){
   global $admin_id, $myredis;
   $sday = strtotime('Today');
   $ss_time = isset($_SESSION['ss_time'])? $_SESSION['ss_time'] : '';
   if($ss_time > 0){
      $key_ss_time_start   = 'timeonsite:' . $sday . ':' . $admin_id . ':time_start:'. $ss_time;
      $myredis->set($key_ss_time_start, time());
   }
}

function end_time_onsite(){
   global $admin_id, $myredis;
   $sday = strtotime('Today');
   $ss_time = isset($_SESSION['ss_time'])? $_SESSION['ss_time'] : '';
   if($ss_time > 0){
      $key_ss_time_end   = 'timeonsite:' . $sday . ':' . $admin_id . ':time_end:'. $ss_time;
      $myredis->set($key_ss_time_end, time());
   }
}


function convert_utf82utf8($str = '',  $removeAccent = 0){
   $new_str = '';
   $marTViet=array(
		// Chữ thường
		"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
		"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ","Đ",
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ","Đ"
		);
	$arrTohop 	=	array( 0 => 'à', 1 => 'á', 2 => 'ạ', 3 => 'ả', 4 => 'ã', 5 => 'â', 6 => 'ầ', 7 => 'ấ', 8 => 'ậ', 9 => 'ẩ', 10 => 'ẫ', 11 => 'ă', 12 => 'ằ', 13 => 'ắ', 14 => 'ặ', 15 => 'ẳ', 16 => 'ẵ', 17 => 'è', 18 => 'é', 19 => 'ẹ', 20 => 'ẻ', 21 => 'ẽ', 22 => 'ê', 23 => 'ề', 24 => 'ế', 25 => 'ệ', 26 => 'ể', 27 => 'ễ', 28 => 'ì', 29 => 'í', 30 => 'ị', 31 => 'ỉ', 32 => 'ĩ', 33 => 'ò', 34 => 'ó', 35 => 'ọ', 36 => 'ỏ', 37 => 'õ', 38 => 'ô', 39 => 'ồ', 40 => 'ố', 41 => 'ộ', 42 => 'ổ', 43 => 'ỗ', 44 => 'ơ', 45 => 'ờ', 46 => 'ớ', 47 => 'ợ', 48 => 'ở', 49 => 'ỡ', 50 => 'ù', 51 => 'ú', 52 => 'ụ', 53 => 'ủ', 54 => 'ũ', 55 => 'ư', 56 => 'ừ', 57 => 'ứ', 58 => 'ự', 59 => 'ử', 60 => 'ữ', 61 => 'ỳ', 62 => 'ý', 63 => 'ỵ', 64 => 'ỷ', 65 => 'ỹ', 66 => 'đ', 67 => 'Đ', 68 => 'À', 69 => 'Á', 70 => 'Ạ', 71 => 'Ả', 72 => 'Ã', 73 => 'Â', 74 => 'Ầ', 75 => 'Ấ', 76 => 'Ậ', 77 => 'Ẩ', 78 => 'Ẫ', 79 => 'Ă', 80 => 'Ằ', 81 => 'Ắ', 82 => 'Ặ', 83 => 'Ẳ', 84 => 'Ẵ', 85 => 'È', 86 => 'É', 87 => 'Ẹ', 88 => 'Ẻ', 89 => 'Ẽ', 90 => 'Ê', 91 => 'Ề', 92 => 'Ế', 93 => 'Ệ', 94 => 'Ể', 95 => 'Ễ', 96 => 'Ì', 97 => 'Í', 98 => 'Ị', 99 => 'Ỉ', 100 => 'Ĩ', 101 => 'Ò', 102 => 'Ó', 103 => 'Ọ', 104 => 'Ỏ', 105 => 'Õ', 106 => 'Ô', 107 => 'Ồ', 108 => 'Ố', 109 => 'Ộ', 110 => 'Ổ', 111 => 'Ỗ', 112 => 'Ơ', 113 => 'Ờ', 114 => 'Ớ', 115 => 'Ợ', 116 => 'Ở', 117 => 'Ỡ', 118 => 'Ù', 119 => 'Ú', 120 => 'Ụ', 121 => 'Ủ', 122 => 'Ũ', 123 => 'Ư', 124 => 'Ừ', 125 => 'Ứ', 126 => 'Ự', 127 => 'Ử', 128 => 'Ữ', 129 => 'Ỳ', 130 => 'Ý', 131 => 'Ỵ', 132 => 'Ỷ', 133 => 'Ỹ', 134 => 'Đ', 135 => 'Đ' );
   if($str != ''){
      $new_str = str_replace($arrTohop, $marTViet, $str);
   }
   
   if($removeAccent == 1){
      $new_str = strtolower(removeAccent($new_str));
   }
   
   return $new_str;

}

function clean_text_error($text = '', $remove_accent = 0){
   $new_text   = '';
   $len  = mb_strlen($text, 'UTF-8');
   for($i = 0;$i<$len;$i++){
      $kt = mb_substr($text, $i, 1, 'UTF-8');
      $ord = ord($kt);
      
      if($ord != 204){
         $new_text .= $kt;
      }
   }
   
   if($remove_accent == 1){
      $new_text   = removeAccent($new_text);
      $new_text   = strtolower($new_text);
   }
   
   $new_text = str_replace('   ', ' ', $new_text);
   $new_text = str_replace('  ', ' ', $new_text);
   $new_text = str_replace('  ', ' ', $new_text);
   
   return $new_text;
}

function convert_number_to_words($number) {
 
   $hyphen      = ' ';
   $conjunction = ' ';
   $separator   = ' ';
   $negative    = 'âm ';
   $decimal     = ' phẩy ';
   $dictionary  = array(
      0                   => 'Không',
      1                   => 'Một',
      2                   => 'Hai',
      3                   => 'Ba',
      4                   => 'Bốn',
      5                   => 'Năm',
      6                   => 'Sáu',
      7                   => 'Bảy',
      8                   => 'Tám',
      9                   => 'Chín',
      10                  => 'Mười',
      11                  => 'Mười một',
      12                  => 'Mười hai',
      13                  => 'Mười ba',
      14                  => 'Mười bốn',
      15                  => 'Mười năm',
      16                  => 'Mười sáu',
      17                  => 'Mười bảy',
      18                  => 'Mười tám',
      19                  => 'Mười chín',
      20                  => 'Hai mươi',
      30                  => 'Ba mươi',
      40                  => 'Bốn mươi',
      50                  => 'Năm mươi',
      60                  => 'Sáu mươi',
      70                  => 'Bảy mươi',
      80                  => 'Tám mươi',
      90                  => 'Chín mươi',
      100                 => 'trăm',
      1000                => 'nghìn',
      1000000             => 'triệu',
      1000000000          => 'tỷ',
      1000000000000       => 'nghìn tỷ',
      1000000000000000    => 'nghìn triệu triệu',
      1000000000000000000 => 'tỷ tỷ'
   );
    
   if (!is_numeric($number)) {
      return false;
   }
    
   if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
   // overflow
   trigger_error(
   'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
   E_USER_WARNING
   );
   return false;
   }
    
   if ($number < 0) {
   return $negative . convert_number_to_words(abs($number));
   }
    
   $string = $fraction = null;
    
   if (strpos($number, '.') !== false) {
   list($number, $fraction) = explode('.', $number);
   }
    
   switch (true) {
   case $number < 21:
   $string = $dictionary[$number];
   break;
   case $number < 100:
   $tens   = ((int) ($number / 10)) * 10;
   $units  = $number % 10;
   $string = $dictionary[$tens];
   if ($units) {
   $string .= $hyphen . $dictionary[$units];
   }
   break;
   case $number < 1000:
   $hundreds  = $number / 100;
   $remainder = $number % 100;
   $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
   if ($remainder) {
   $string .= $conjunction . convert_number_to_words($remainder);
   }
   break;
   default:
   $baseUnit = pow(1000, floor(log($number, 1000)));
   $numBaseUnits = (int) ($number / $baseUnit);
   $remainder = $number % $baseUnit;
   $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
   if ($remainder) {
   $string .= $remainder < 100 ? $conjunction : $separator;
   $string .= convert_number_to_words($remainder);
   }
   break;
   }
    
   if (null !== $fraction && is_numeric($fraction)) {
   $string .= $decimal;
   $words = array();
   foreach (str_split((string) $fraction) as $number) {
   $words[] = $dictionary[$number];
   }
   $string .= implode(' ', $words);
   }
 
   return $string;
}

/**
 * redirec header 301
 */
function header_301($url = ''){
    if($url != ''){
        Header( "HTTP/1.1 301 Moved Permanently" );
        Header( "Location: " . $url );
        exit();
    }
}


function generatePageBar($page_prefix, $current_page, $page_size, $total_record, $url, $normal_class, $selected_class, $previous='<', $next='>', $first='<<', $last='>>', $break_type=1, $page_rewrite=0, $page_space=3, $obj_response='', $page_name="page"){

    $page_query_string	= "&" . $page_name . "=";
    // Nếu dùng ModRewrite thì dùng dấu , để phân trang
    if($page_rewrite == 1) $page_query_string = ",";

    if($total_record % $page_size == 0) $num_of_page = $total_record / $page_size;
    else $num_of_page = (int)($total_record / $page_size) + 1;

    if($page_space > 4) $page_space = 3;
    if($page_space < 1) $page_space = 3;

    $start_page = $current_page - $page_space;
    if($start_page <= 0) $start_page = 1;

    $end_page = $current_page + $page_space;
    if($end_page > $num_of_page) $end_page = $num_of_page;

    // Remove XSS
    $url = str_replace('\"', '"', $url);
    $url = str_replace('"', '', $url);

    if($break_type < 1) $break_type = 1;
    if($break_type > 4) $break_type = 4;

    // Pagebreak bar
    $page_bar = "";

    // Write prefix on screen
    if($page_prefix != "") $page_bar .= '<span class="vl_page' . $normal_class . '">' . $page_prefix . '</span> ';

    // Write frist page
    if($break_type == 1){
        if(($start_page != 1) && ($num_of_page > 1)){
            if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . '1' . '\',\'' . $obj_response . '\')';
            else $href = $url . $page_query_string . '1';
            $page_bar .=  '<a href="' . $href . '" class="' . $normal_class . ' firstpage" title="First page">' . $first . '</a> ';
        }
    }

    // Write previous page
    if($break_type == 1 || $break_type == 2 || $break_type == 4){
        if(($current_page > 1) && ($num_of_page > 1)){
            if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . ($current_page - 1) . '\',\'' . $obj_response . '\')';
            else $href = $url . $page_query_string . ($current_page - 1);
            $page_bar .= ' <a href="' . $href . '" class="' . $normal_class . ' prevpage" title="Prev page">' . $previous . '</a> ';
            if(($start_page > 1) && ($break_type == 1 || $break_type == 2)){
                $page_dot_before = $start_page - 1;
                if($page_dot_before < 1) $page_dot_before = 1;
                if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . $page_dot_before . '\',\'' . $obj_response . '\')';
                else $href = $url . $page_query_string . $page_dot_before;
                $page_bar .= '<a href="' . $href . '" class="' . $normal_class . ' notUndeline">...</a> ';
            }
        }
    }

    // Write page numbers
    if($break_type == 1 || $break_type == 2 || $break_type == 3){
        $start_loop = $start_page;
        if($break_type == 3) $start_loop = 1;
        $end_loop	= $end_page;
        if($break_type == 3) $end_loop = $num_of_page;
        for($i=$start_loop; $i<=$end_loop; $i++){
            if($i != $current_page){
                if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . $i . '\',\'' . $obj_response . '\')';
                else $href = $url . $page_query_string . $i;
                $page_bar .= ' <a href="' . $href . '" class="' . $normal_class . '">' . $i . '</a> ';
            }
            else{
                $page_bar .= ' <span class="vl_page ' . $normal_class . ' ' . $selected_class . '">' . $i . '</span> ';
            }
        }
    }

    // Write next page
    if($break_type == 1 || $break_type == 2 || $break_type == 4){
        if(($current_page < $num_of_page) && ($num_of_page > 1)){
            if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . ($current_page + 1) . '\',\'' . $obj_response . '\')';
            else $href = $url . $page_query_string . ($current_page + 1);
            if(($end_page < $num_of_page) && ($break_type == 1 || $break_type == 2)){
                $page_dot_after = $end_page + 1;
                if($page_dot_after > $num_of_page) $page_dot_after = $num_of_page;
                if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . $page_dot_after . '\',\'' . $obj_response . '\')';
                else $href = $url . $page_query_string . $page_dot_after;
                $page_bar .= '<a href="' . $href . '" class="' . $normal_class . ' notUndeline">...</a> ';
            }
            $page_bar .= ' <a href="' . $href . '" class="' . $normal_class . ' nextpage" title="Next page">' . $next . '</a> ';
        }
    }

    // Write last page
    if($break_type == 1){
        if(($end_page < $num_of_page) && ($num_of_page > 1)){
            if($obj_response != '') $href = 'javascript:load_data(\'' . $url . $page_query_string . $num_of_page . '\',\'' . $obj_response . '\')';
            else $href = $url . $page_query_string . $num_of_page;
            $page_bar .= ' <a href="' . $href . '" class="' . $normal_class . ' lastpage" title="Last page">' . $last . '</a>';
        }
    }

    // Return pagebreak bar
    return $page_bar;

}

?>