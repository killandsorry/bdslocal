<?php
	define('URL_LOAD_EVENT_CHAT','http://live.vnpgroup.net/js/chat.php');
	define('CHAT_APPLICATION_SECRET','fsljfdlslf232l4l23');
	define('CHAT_APPLICATION_ID',1);
	define('CHAT_VERSION_VCHAT_ON',1);
	define('CHAT_ACTION_ADD_TO_CART','action_add_tocart');
	define('CHAT_ACTION_PAYMENT','action_payment');
	if(!defined('CHAT_START_GUEST_ID')){
		define('CHAT_START_GUEST_ID',10000000);
	}
	/**
	 * Class ket noi toi server nodejs de thuc hien
	 */
	 class socketIoClient{

			var $js     = '';
			var $array_onRaw            = array();
			var $array_func_onRaw       = array();
			var $http_baseUrl           = '';
			var $domain                 = '';
			var $server                 = ''; //server ape
			var $ape_status_on			 = false; //tr?ng thái ape b?t hay không
			var $array_box_notify		 = array();
			var $server_nodejs			 = "";
			protected $arrayChannel		 = array();
			protected $array_id_check_online	= array();
			protected $arrayData			 = array();
			protected $showBarChat		 = false;
			protected $db_init 			 = null;
			protected $js_require		 = '';
			protected $my_sso_id			 = 0;
			protected $pro_id				 = 0;
			protected $js_load_chat		 = '';
			protected $proinfo			 = '';
			protected $data_action		 = array();

			/**
			 * Ham khoi tao
			 */
		 	function __construct($user_sso_id = 0){
		 		global $staticVatgiaServer;
		    	//$this->db_init = new db_ape_init();
//		      $this->http_baseUrl 		= $this->db_init->ape_baseUrl;
//		      $this->domain       		= $this->db_init->ape_domain;
//		      $this->server       		= $this->db_init->ape_client;
//		      $this->ape_status_on		= $this->db_init->ape_status_on;
//		      $this->server_nodejs		= $this->db_init->nodejs_server;
		      $this->my_sso_id			= $user_sso_id;

		      //n?u tr?ng thái ape ho?t d?ng
		    	if(!$this->ape_status_on) return false;


		      //bat dau khoi tao connection toi server nodejs kem them truyen du lieu connect len server
		      //$this->js	.= 'var socket = io.connect("' . $this->server_nodejs . '",{ query: RealtimeDataConnect });';
		      //bat dau mo connection
				//$this->js	.= 'socket.on("connect", function () {';
				//khoi tao ham iniloadChatVatgia
				//$this->js	.= 'function iniLoadChatVatGia(){';

		 	}//end __construct

		 	/**
		 	 * Join channel connect
		 	 */
	 	 	public function joinUserSSO($user_sso_id){
	 	 		$channel = $user_sso_id;
	 	 		if(!in_array($channel, $this->arrayChannel)){
	 	 			$this->arrayChannel[] = $channel;
	 	 		}
	 	 	}

		 	/**
			  * Ham tuong tu onRaw nhung dung cho nodejs
			  */
			public function onRaw($raw_name, $js_text = ""){
				$this->array_onRaw[]       =	'socket.on("' . $raw_name . '", function (raw) {
														    ' . $js_text . '
														});';
			}

			/**
			 * Set id san pham cua vatgia neu co
			 */
		 	public function setProductId($pro_id){
		 		$this->pro_id = intval($pro_id);
		 	}
		 	
		 	/**
		 	 * Ham để gửi 1 thông báo của hệ thống tạo ra cuộc chat
		 	 */
		 	 function systemSendAction($action_name, $to_use_id = 0, $data = array()){
		 	 		$data["to_use_id"] = $to_use_id;
	 	 			$this->data_action[$action_name] = $data;
		 	 } 

			/**
			 * Ham load chat
			 */
		 	public function loadChat($arrayUserId = array(), $load_css = 1, $feed = 0, $sso_id_support = 0){
		 		asort($arrayUserId);
		 		$listid = '';
		 		if(!empty($arrayUserId)){
		 			$listid = implode(",",$arrayUserId);
		 		}
		 		$arrayParam = array(
				 							 "listid" => $listid
				 							,"app_id" => CHAT_APPLICATION_ID
				 							,"sso_id" => $this->my_sso_id
				 							,"iPro" 	 => $this->pro_id
				 							,"css" => $load_css
				 							,"feed" => $feed
				 							,"proinfo" => $this->proinfo
				 							,"system_action"  => $this->data_action 
				 							,"ch"		 => $this->arrayChannel
				 							);
				if($sso_id_support > 0){
					$arrayParam["id_support"] = $sso_id_support;
				}
				ksort($arrayParam);
				$data = base64_url_encode(json_encode($arrayParam));
				$hash = $this->checkSum($data);
		 		//nếu raw là chat thì thêm đoạn load dữ liệu chat từ server chat về
		 		$url 	= sprintf( "%s?%s", URL_LOAD_EVENT_CHAT, http_build_query( array("hash" => $hash,"data" => $data), "", "&" ) );
		 		$this->js_load_chat		= 'var guest_id = VatGiaChatReadCookie("chat_guest_id");';
		 		$this->js_load_chat		.= 'var vg_history = VatGiaChatReadCookie("vgchat_history");';
				$this->js_load_chat		.= $this->require_js($url, true,'+"&g="+guest_id+"&h="+vg_history');
				$this->onRaw("chat","fn_raw_chat(raw.data);");
		 	}
		 	
		 	/**
		 	 * Ham set product info de ban thong tin feed ve gian hang
		 	 */
	 	 	function addInfoFeedProduct($data_json){
	 	 		$this->proinfo = $data_json;
	 	 	}

		 	/**
		 	 * Ham checksum du lieu gui di thong qua secret va app_id
		 	 */
	 	 	protected function checkSum($string){
	 	 		$hash	=	md5($string . "<>" . CHAT_APPLICATION_ID . "::" . CHAT_APPLICATION_SECRET);
	 	 		return $hash;
	 	 	}

			/**
		     * ham truong tu generate_ape_script nhung dung cho nodejs
		     */
			public function generate_script($data_join = "", $show_panel = 1){

				global $myuser;
				//phan join cac channel len server
				//foreach($this->arrayChannel as $key => $value) $this->arrayChannel[$key] = md5("user_" . $value);
				//$this->arrayData	= array(
//										  "channel" 	=> $this->arrayChannel
//		  								 ,"checksum"	=>	md5($_SERVER["REMOTE_ADDR"] . "|" . $this->db_init->ape_password)
//										 ,"data" 		=> ""
//										 );
//
//				$this->arrayData["data"] = $data_join;

				//them bien du lieu truyen di khi connect toi server
				//$this->js	= 'var RealtimeDataConnect ="data=' . rawurlencode(json_encode($this->arrayData)) . '&logged=' . (($this->my_sso_id > 0) ? 1 : 0) . '"; ' . $this->js;

				//neu ape khong duoc bat thi return luon
				//if(!$this->ape_status_on) return false;

				//neu yeu cau hien thi show panel chat o goc phai
				//if($show_panel == 1) $this->js .=	$this->chat_generate_panel();

				$str_iniLoadChatVatGia = 'function iniLoadChatVatGia(){';

				//ghep cac event user add vao
				foreach($this->array_onRaw as $key=>$func){
					$str_iniLoadChatVatGia .= $func;
				}

				$str_iniLoadChatVatGia .= "};";
				//dong lai the socket.on("connect", function ()  o ham nodejs_generate_js
				//$this->js	.=	"});";
				//dong ham iniLoadChatVatgia
				//$this->js	.=	"};";
				$this->js	.= $this->js_load_chat;

				//khai bao doan js de kiem tra xem io da load chua
				$js_check_load_io = 'var myIoLoaded = setInterval(function(){ioLoadConnect()},100);';
				$js_check_load_io .= 'var count_myIoLoaded = 0;';
				$js_check_load_io .= 'function ioLoadConnect(){';
				$js_check_load_io .= 'if (typeof io !== "undefined") {
												 clearInterval(myIoLoaded);
												 ' . $this->js . '
											}else{
												count_myIoLoaded++;
												if(count_myIoLoaded > 100) clearInterval(myIoLoaded);
											};';
				$js_check_load_io .= '};';
				$js_check_load_io = $this->js_require . $str_iniLoadChatVatGia . $js_check_load_io;
				//$js_check_load_io = str_replace(array(chr(9),chr(10),chr(13)),"",$js_check_load_io);
				$js_check_load_io = str_replace(array("  ","  ","  ")," ",$js_check_load_io);
				//tra ve du lieu cuoi cung
				return $js_check_load_io;

			}
			
			public function generate_script_v2($data_join = "", $show_panel = 1){
				$str_iniLoadChatVatGia = '';
				$str_iniLoadChatVatGia .= 'function showNotificationBrowser(e){try{Notification.requestPermission(function(e){});execute_notification(e)}catch(t){}}';
				$str_iniLoadChatVatGia .= 'function VatGiaChatCreateCookie(e,t,n){if(n){var r=new Date;r.setTime(r.getTime()+n*12*60*60*1e3);var i="; expires="+r.toGMTString()}else var i="";document.cookie=e+"="+t+i+"; path=/"}function VatGiaChatReadCookie(e){var t=e+"=";var n=document.cookie.split(";");for(var r=0;r<n.length;r++){var i=n[r];while(i.charAt(0)==" ")i=i.substring(1,i.length);if(i.indexOf(t)==0)return i.substring(t.length,i.length)}return null};';
				$str_iniLoadChatVatGia .= 'function iniLoadChatVatGia(){';

				//ghep cac event user add vao
				foreach($this->array_onRaw as $key=>$func){
					$str_iniLoadChatVatGia .= $func;
				}

				$str_iniLoadChatVatGia .= "};";
				$str_iniLoadChatVatGia .= $this->js_load_chat;
				$str_iniLoadChatVatGia = str_replace(array("  ","  ","  ")," ",$str_iniLoadChatVatGia);
				return $str_iniLoadChatVatGia;
			}
			//http://ad.vatgia.com/jsv2/vgchat_10.js
			public function require_js($url_js_file = "", $return = false,$add_param = ''){
				$key = "js_" . md5($url_js_file);
				$str = '$(function() {
								var ' . $key . '= false;
								if(!' . $key . '){
									var ga = document.createElement("script");
									ga.type = "text/javascript";
									ga.id = "' . $key . '";
									ga.src = "' . $url_js_file . '"' . $add_param . ';
									var s = document.getElementsByTagName("script");
									s[0].parentNode.insertBefore(ga, s[0]);
								}
							});';
				if($return){
					return $str;
				}else{
					$this->js_require .= $str;
					return '';
				}
			}

 	}//end class
?>