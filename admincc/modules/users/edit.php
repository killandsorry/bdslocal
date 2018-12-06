<meta charset="utf-8" />
<?
include("inc_security.php");
//Khai báo biến khi thêm mới
$fs_redirect		=	base64_url_decode(getValue("url", "str", "GET", base64_url_encode("listing.php")));
$fs_title			= "Tin đăng"; //tên tiêu đề bân trái
$fs_action			= getURL();//reload lại
$fs_errorMsg		= "";//lỗi trả về nếu thêm mới không đc
$dat_last_update			= time();//lấy ngày hiện hành
$record_id			= getValue("record_id");
$use_date_expires						= getValue('use_date_expires', 'str', 'POST', '');
$use_date_expires						= convertDateTime($use_date_expires, '23:59:59');

$myform	=	new generate_form();//tạo form mới
$myform->removeHTML(0);
//thêm các trường vào form


//Add table insert data
$myform->addTable($fs_table);
$errorMsg	= "";

//Get action variable for add new data
$action				= getValue("action", "str", "POST", ""); //kiểm tra xem form có đc submit đi không
//Check $action for insert new data
if($action == "execute"){
   $myform->add("use_date_expires", "use_date_expires", 1, 1, "", 1, "Vui lòng nhập Ngày hết hạn", 0, ""); //tiêu đề tin
   $myform->add("use_fix_branch", "use_fix_branch", 1, 0, 1, 1, "Vui lòng nhập Ngày hết hạn", 0, ""); //tiêu đề tin
   $myform->add("use_payment", "use_payment", 1, 0, 0, 0, "", 0, ""); //Ngay dang
   $myform->add("use_supplier", "use_supplier", 1, 1, 2, 0, "", 0, ""); //Ngay dang
   
   $use_supplier  = 2;
   $supplier   = getValue('user_type', 'arr', 'POST', array());
   if(!empty($supplier)){
      $use_supplier  += array_sum($supplier);
   }
   
	$fs_errorMsg .= $myform->checkdata();
   
	//thực hiện thêm mới nếu không có lỗi
	if($fs_errorMsg == ""){
		//không remove ký tự html
		$myform->removeHTML(0);
		//echo $myform->generate_insert_SQL();
		$total_record = 0;
		
		$use_payment = getValue("use_payment","int","POST");
      
		if($use_payment == 1){		    
         $db_check_user    = new db_query("SELECT * FROM users WHERE use_id = " . $record_id . " LIMIT 1");
         if($row  = $db_check_user->fetch()){
            if($row['use_payment'] == 0){
               $total_record = activeUserPayment($record_id,$admin_id,$use_date_expires);
            }
         }  
         unset($db_check_user);
		}
      
      $db_ex 	= new db_execute($myform->generate_update_SQL("use_id", $record_id));
      
		if($record_id > 0){
			echo "<script>alert('Cập nhật thành công có " . $total_record . " bản ghi được tạo')</script>";
		} else {
			echo "<script>alert('Cập nhật không thành công')</script>";
		}
		redirect($fs_redirect);
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<style>
#pic_detail{
	height: 100px; overflow: hidden;
}
#pic_detail img{
	width: 100px; margin-right: 20px;
}
#pic_detail .img{
	position: relative;display: inline-block;
}
#pic_detail .delimg{
	background-color: #fff;  color: #f00;   cursor: pointer;   font-style: normal;   padding: 0 3px 3px 5px;   position: absolute;   right: 21px;   top: 1px;
}
</style>
<?
//add form for javacheck
$myform->addFormname("add");//(tên form name)
$myform->checkjavascript();

//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();

$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM " . $fs_table . " WHERE " . $id_field . " = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
	foreach($row as $key=>$value){
		if($key!='lang_id' && $key!='admin_id') $$key = $value;
		if(isset($_POST[$key])) $$key = $_POST[$key];
	}
}else{
		exit();
}
?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER["REQUEST_URI"], "POST", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table(3,3,'width="100%"');
	?>
		<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
		<?=$form->errorMsg($fs_errorMsg)?>
      <tr>
   		<td class="form_name">Ngày hết hạn</td>
   		<td>
   			<input type="text" value="<?=date('d/m/Y', $use_date_expires)?>" name="use_date_expires" id="use_date_expires" onKeyPress="displayDatePicker('use_date_expires', this);" onClick="displayDatePicker('use_date_expires', this);" />
   		</td>
   	</tr>
      <?=$form->checkbox('Sử dụng trả phí', 'use_payment', 'use_payment', 1, $use_payment, 'Sử dụng trả phí')?>
      <tr>
   		<td class="form_name">Loại tài khoản</td>
   		<td>
   			<?
            foreach($array_user_type as $t => $tname){
               $ch   = (($t & $use_supplier) == $t)? 'checked="checked"' : '';
               ?>
               <div>
                  <input <?=$ch?> type="checkbox" value="<?=$t?>" id="typeu_<?=$t?>" name="user_type[]" />
                  <label for="typeu_<?=$t?>"><?=$tname?></label>
               </div>
               <?
            }
            ?>
   		</td>
   	</tr>
      <tr>
         <td class="form_name">Số chi nhánh</td>
         <td><input type="text" value="<?=$use_fix_branch?>" name="use_fix_branch" /></td>
      </tr>
      <input type="hidden" value="<?=$record_id?>" name="user_id" id="user_id" />
		<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
		<?=$form->hidden("action", "action", "execute", "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>
	</p>
<? /*------------------------------------------------------------------------------------------------*/ ?><?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
<script>
   function create_database(){
      $.post(
         'create_table.php',
         {user_id : $('#user_id').val()},
         function (res){
            if(res.status == 0){
               alert(res.error);
               return false;
            }else{
               if(confirm("Tạo bảng dữ liệu thành công \n Bạn có muốn chuyển dữ liệu từ bảng dùng thử sang bảng mới không")){
                  convert_database();
               }
            }
         },
         'json'
      )
   }
   function convert_database(){
      $.post(
         'convert_database.php',
         {user_id : $('#user_id').val()},
         function (res){
            if(res.status == 0){
               alert(res.error);
               return false;
            }else{
               alert('Chuyển dữ liệu thành công');
            }
         },
         'json'
      )
   }
</script>
</html>