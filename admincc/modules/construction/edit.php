<?
require_once("inc_security.php");

#+
#+ Kiem tra quyen them sua xoa
//checkAddEdit("edit");

#+
#+ Khai bao bien
$add				= "add.php";
$listing			= "listing.php";
$edit				= "edit.php";
$after_save_data	= getValue("after_save_data", "str", "POST", $listing);

$errorMsg 			= "";		//Warning Error!
$action				= getValue("action", "str", "POST", "");
$fs_action			= getURL();
$record_id			= getValue("record_id");
$con_no_accent		= '';
#+
#+ Goi class generate form
$myform = new generate_form();	//Call Class generate_form();
#+ Khai bao thong tin cac truong
$myform->add("con_name", "con_name", 0, 0, '', 1, "Chưa nhập chủ đầu tư", 0, "");
$myform->add("con_no_accent", "con_no_accent", 0, 1, 0, 0, "", 0, "");
$myform->add("con_full_address", "con_full_address", 0, 0, "", 1, "Bạn chưa nhập địa chỉ", 0, "");
$myform->add("con_home_phone", "con_home_phone", 0, 0, '', 1, "Bạn chưa nhập ĐT bàn", 0, "");
$myform->add("con_hot_line", "con_hot_line", 0, 0, '', 0, "", 0, "");
$myform->add("con_email", "con_email", 0, 0, '', 0, "", 0, "");
$myform->add("con_website", "con_website", 0, 0, '', 0, "", 0, "");
$myform->add("con_title", "con_title", 0, 0, '', 1, "Chưa nhập title seo", 0, "");
$myform->add("con_description", "con_description", 0, 0, '', 1, "Chưa nhập description seo", 0, "");
$myform->add('con_introduction', 'con_introduction', 6, 1, '', 1, 'Chưa nhập nội dung chi tiết', 0, '');
$myform->addTable($fs_table);

$con_introduction	= getValue('con_introduction', 'str', 'POST', '');
$html_clean			= new html_cleanup($con_introduction);
$html_clean->clean();
$con_introduction	= $html_clean->output_html;

$con_introduction	= str_replace('http://%5C%22', '', $con_introduction);
$con_introduction	= str_replace('%5C%22', '', $con_introduction);
$con_introduction	= str_replace('%22', '', $con_introduction);
$con_introduction	= str_replace('http://http://', 'http://', $con_introduction);
$con_introduction	= str_replace('http://https://', 'https://', $con_introduction);


#+
#+ đổi tên trường thành biến và giá trị
$myform->evaluate();

#+
#+ Neu nhu co submit form
if($action == "submitForm"){

	#+
	#+ Kiểm tra lỗi
    $errorMsg .= $myform->checkdata();
	# $errorMsg .= $myform->strErrorField ;	//Check Error!
	if($errorMsg == ""){
		#+
		#+ Thuc hien query
		$db_ex	 		= new db_execute_return();
		$query			= $myform->generate_update_SQL($field_id, $record_id);
		$last_id 		= $db_ex->db_execute($query);
        redirect($listing);
	}
}

#+
#+ Khai bao ten form
$myform->addFormname("submitForm"); //add  tên form để javacheck
#+
#+ Xử lý javascript
$myform->addjavasrciptcode('');
$myform->checkjavascript();

#+
#+ lay du lieu cua record can sua doi
$query = "SELECT * FROM " . $fs_table . "  WHERE " . $field_id . " = " . $record_id;
$db_data 	= new db_query($query);

if($row 	= mysqli_fetch_assoc($db_data->result))
{
	foreach($row as $key=>$value)
	{
		if($key!='lang_id' && $key!='admin_id') $$key = $value;
	}
}else
{
	exit();
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top(translate_text("Records Add"))?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?
$form = new form();
$form->create_form("form_name",$fs_action,"post","multipart/form-data",'onsubmit="validateForm();return false;"  id="form_name" ');
$form->create_table();
?>
<?=$form->text_note('Những ô dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
<?=$form->errorMsg($errorMsg)?>

<?=$form->text("Đv thi công", "con_name", "con_name", $con_name, "Đv thi công", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Địa chỉ", "con_full_address", "con_full_address", $con_full_address, "Địa chỉ", 1, 500, "", 255, "", "", "")?>
<?=$form->text("ĐT bàn", "con_home_phone", "con_home_phone", $con_home_phone, "Điện thoại bàn", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Hotline", "con_hot_line", "con_hot_line", $con_hot_line, "Hotline", 0, 500, "", 255, "", "", "")?>
<?=$form->text("Email", "con_email", "con_email", $con_email, "Email", 0, 500, "", 255, "", "", "")?>
<?=$form->text("Website", "con_website", "con_website", $con_website, "Website", 0, 500, "", 255, "", "", "")?>
<?=$form->text("Seo title", "con_title", "con_title", $con_title, "Title seo", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Seo desciption", "con_description", "con_description", $con_description, "Des seo", 1, 500, "", 255, "", "", "")?>

<?=$form->close_table();?>
<?=$form->wysiwyg("Chi tiết CĐT", "con_introduction", $con_introduction, "../../resource/ckeditor/", "95%", 400)?>
<?=$form->create_table();?>

<?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing" . $form->ec . "return_edit", "after_save_data", $add . $form->ec . $listing . $form->ec . $edit, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách" . $form->ec . "Sửa bản ghi", 0, "" . $form->ec . "" . $form->ec . "");?>
<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat; border:none;"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif) no-repeat; border:none;"', "");?><br />
<?=$form->hidden("action", "action", "submitForm", "");?>

<?
$form->close_table();
$form->close_form();
unset($form);
?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>