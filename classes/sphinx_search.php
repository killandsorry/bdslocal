<?
/**
 * class dung sphinx tim kiem tu khoa cua ad vatgia
 */
class sphinx_search_rv{
	
	//tu khoa toi da ky tu
	var $max_keyword_length 	= 50;
	//Có thành công khi search sphinx hay không
	var $search_successful 		= false;
	var $array_search_keyword	= array();	
	//Server Config here
	var $sphinx_host 				= "localhost";
	var $sphinx_port 				= 33120;
	var $index_search_keyword	= "luongcao_keyword";
	var $keyword					= "";
	var $original_keyword		= "";
	var $total_result				=	0;
	var $arrayQuery				=	array();
	var $key_query					=	0;
	
	var $array_keyword = array();
	
	/**
	 * Ham khi tao bat dau
	 */
 	function sphinx_search($any = 0){
 		
		
		if($_SERVER["SERVER_NAME"] == "localhost"){
			$this->sphinx_host = "127.0.0.1";
		}
		
		//Khởi tạo class và mở kết nối đến server
		$this->sphinx = new SphinxClient();
		$this->sphinx->SetServer($this->sphinx_host, $this->sphinx_port);
		$this->sphinx->SetConnectTimeout(1.5);
		//$this->sphinx->SetMatchMode(SPH_MATCH_ALL);
		//Lấy max 5030 kết quả trả về
		$this->sphinx->_maxmatches = 330;
		$this->sphinx->Open();
		$this->sphinx->SetLimits(0, 1000);
		if($any == 1){
			$this->sphinx->SetMatchMode(SPH_MATCH_ANY);
		}else{
			$this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
		}
 		
 	} //end function
	
	/**
	 * Hàm làm sạch những ký tự đặc biệt đối với keyword
	 */
 	function clean_up_keyword($keyword){
 		
 		//nếu từ khóa dài quá với ký tự cho phép thì cắt ngắn bớt
 		if (mb_strlen($keyword,"UTF-8") > $this->max_keyword_length) $keyword = mb_substr($keyword,0,$this->max_keyword_length,"UTF-8");
 		$keyword = mb_strtolower($keyword,"UTF-8");
		//Remove "
		$keyword = str_replace("&quot;","",$keyword);
		
		//Replace các bad character
		$array_bad_word = array("?","^",",",";","*","/","~","@","-","!","[","]","(",")","=","|");
		$keyword = str_replace($array_bad_word,"",$keyword);

		//Chống các ký tự ô vuông, convert lại đúng kiểu UTF-8
		$keyword = mb_convert_encoding($keyword,"UTF-8","UTF-8");
		
		//Xóa bỏ ký tự NCR
		$convmap = array(0x0, 0x2FFFF, 0, 0xFFFF);
		$keyword = @mb_decode_numericentity($keyword, $convmap, "UTF-8");
		return $keyword;
 	}
	
	
	/**
	 * Hàm add thêm query search
	 */
	function addQuery($query_name, $keyword, $option = array()){
		$groupby = isset($option["groupby"]) ? $option["groupby"] : 0;
		$this->arrayQuery[$this->key_query]	=	array("key" => $query_name, "groupby" => $groupby);
		$keyword	=	$this->clean_up_keyword($keyword);
		$this->sphinx->AddQuery($keyword, $this->index_search_keyword);
		$this->key_query++;
	}
	
	/**
	 * Ham lay ket qua query
	 */
 	function ResultQuery(){
 		
 		//$arrayReturn 	=	array();
 		$results = $this->sphinx->RunQueries();
 		//print_r($results);
 		$arrayTemp	=	array();
 		foreach($results as $key => $result){
 			//nếu tồn tại key của query
 			if(isset($this->arrayQuery[$key])){
 				//hủy key đó và thêm key mới bằng name
 				$arrayTemp[$this->arrayQuery[$key]["key"]] = $this->getResult($result, $this->arrayQuery[$key]["groupby"]);
 			}
 		}
 		$this->arrayQuery = $arrayTemp;
 		unset($arrayTemp);
 		return $this->arrayQuery;
 	}
	
	protected function getResult($result, $groupby = 0){
		//return $result;
		$arrayReturn = array();
		if ($result === false){
			$this->savaErrorLog("Query failed (" . $this->index_search_keyword . "): " . $this->sphinx->GetLastError() . ".\n");
			//Return false luôn
			return false;
		}
		else{
			if ($this->sphinx->GetLastWarning()){
				//Dump ra cảnh báo
				$this->savaErrorLog("WARNING (" . $this->index_search_keyword . "): " . $this->sphinx->GetLastWarning() . "");
			}
			if (!empty($result["matches"])){
				foreach ($result["matches"] as $doc => $docinfo) {
					//Thêm vào array trả về key = cat_id, value = count
					//neu la group by
					if($groupby == 1){
						$arrayReturn[intval($docinfo["attrs"]["@groupby"])] = $docinfo["attrs"]["@count"];
					}else{
						$arrayReturn[intval($doc)] = $docinfo["weight"];	
						$this->total_result++;
					}
					
					
				}//End foreach
			}//End if (!empty)
		}
		return ($arrayReturn);
	}
	
	/*
	Search keyword relate
	*/
	function search_keyword(){
		//Set array tra về là rỗng
		$this->array_search_keyword = array();

		//Reset để bỏ GroupBy
		$this->sphinx->ResetGroupBy();
				
		//phân trang
		
		
		
		//echo $this->original_keyword;
		//echo $this->keyword;
		//$this->keyword	=	"@(adk_keyword,adv_title,adv_description) " . $this->keyword . '';
		//echo $this->keyword;
		//Bắt đầu search
		$this->sphinx->AddQuery($this->keyword, $this->index_search_keyword);
		$this->sphinx->AddQuery("dell", $this->index_search_keyword);
		//$result = $this->sphinx->Query($this->keyword, $this->index_search_keyword);
		$result = $this->sphinx->RunQueries ();
	
		
		//Nếu không trả lại đc kết quả
		if ($result === false){
			$this->savaErrorLog("Query failed (" . $this->index_search_keyword . "): " . $this->sphinx->GetLastError() . ".\n");
			//Return false luôn
			return false;
		}
		else{
			if ($this->sphinx->GetLastWarning()){
				//Dump ra cảnh báo
				$this->savaErrorLog("WARNING (" . $this->index_search_keyword . "): " . $this->sphinx->GetLastWarning() . "");
			}
			if (!empty($result["matches"])){
				foreach ($result["matches"] as $doc => $docinfo) {
					//Thêm vào array trả về key = cat_id, value = count
					$this->array_search_keyword[$doc] = $docinfo["weight"];
					$this->total_result++;
				}//End foreach
			}//End if (!empty)
		}
		
		return true;
	}
	/*-----------Kết thúc search keyword--------*/
	/*
	Đóng kết nối với sphinx server
	*/
	function CloseConnection(){
		//Đóng kết nối
		$this->sphinx->Close();
	}
	
	/*
	Save error log
	*/
	function savaErrorLog($log_message){
		$filename = "../logs/sphinx_error.cfn";
		$handle = @fopen($filename, 'a');
		//Nếu handle chưa có mở thêm ../
		if (!$handle) $handle = @fopen("../" . $filename, 'a');
		//Nếu ko mở đc lần 2 thì return luôn
		if (!$handle) return;
		
		fwrite($handle, date("d/m/Y h:i:s A") . " " . $_SERVER['REMOTE_ADDR'] . " " . $_SERVER['SCRIPT_NAME'] . "?" . @$_SERVER['QUERY_STRING'] . "\n" . $log_message . "\n");
		fclose($handle);	
	}
}
?>