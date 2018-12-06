<?
require_once("inc_security.php");

#+
#+ Kiem tra quyen them sua xoa
checkAddEdit("add");

#+
#+ Khai bao bien
$add				= "add.php";
$listing			= "listing.php";
$edit				= "edit.php";
$after_save_data	= getValue("after_save_data", "str", "POST", $listing);

$errorMsg 			= "";		//Warning Error!
$action				= getValue("action", "str", "POST", "");
$fs_action			= getURL();
$inv_no_accent		= '';


#+
#+ Goi class generate form
$myform = new generate_form();	//Call Class generate_form();
#+ Khai bao thong tin cac truong
$myform->add("inv_name", "inv_name", 0, 0, '', 1, "Chưa nhập chủ đầu tư", 0, "");
$myform->add("inv_no_accent", "inv_no_accent", 0, 1, 0, 0, "", 0, "");
$myform->add("inv_full_address", "inv_full_address", 0, 0, "", 1, "Bạn chưa nhập địa chỉ", 0, "");
$myform->add("inv_home_phone", "inv_home_phone", 0, 0, '', 1, "Bạn chưa nhập ĐT bàn", 0, "");
$myform->add("inv_hot_line", "inv_hot_line", 0, 0, '', 0, "", 0, "");
$myform->add("inv_email", "inv_email", 0, 0, '', 0, "", 0, "");
$myform->add("inv_website", "inv_website", 0, 0, '', 0, "", 0, "");
$myform->add("inv_title", "inv_title", 0, 0, '', 1, "Chưa nhập title seo", 0, "");
$myform->add("inv_description", "inv_description", 0, 0, '', 1, "Chưa nhập description seo", 0, "");
$myform->add('inv_introduction', 'inv_introduction', 6, 1, '', 1, 'Chưa nhập nội dung chi tiết', 0, '');
$myform->addTable($fs_table);

$inv_introduction	= getValue('inv_introduction', 'str', 'POST', '');


$inv_introduction	= str_replace('http://%5C%22', '', $inv_introduction);
$inv_introduction	= str_replace('%5C%22', '', $inv_introduction);
$inv_introduction	= str_replace('%22', '', $inv_introduction);
$inv_introduction	= str_replace('http://http://', 'http://', $inv_introduction);
$inv_introduction	= str_replace('http://https://', 'https://', $inv_introduction);


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
		$inv_id			= $db_ex->db_execute($myform->generate_insert_SQL());
		if($inv_id > 0){
            redirect($add);
		}

	}
}

#+
#+ Khai bao ten form
$myform->addFormname("submitForm"); //add  tên form để javacheck
#+
#+ Xử lý javascript
$myform->addjavasrciptcode('');
$myform->checkjavascript();
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

<?=$form->text("Chủ đầu tư", "inv_name", "inv_name", $inv_name, "Chủ đầu tư", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Địa chỉ", "inv_full_address", "inv_full_address", $inv_full_address, "Địa chỉ", 1, 500, "", 255, "", "", "")?>
<?=$form->text("ĐT bàn", "inv_home_phone", "inv_home_phone", $inv_home_phone, "Điện thoại bàn", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Hotline", "inv_hot_line", "inv_hot_line", $inv_hot_line, "Hotline", 0, 500, "", 255, "", "", "")?>
<?=$form->text("Email", "inv_email", "inv_email", $inv_email, "Email", 0, 500, "", 255, "", "", "")?>
<?=$form->text("Website", "inv_website", "inv_website", $inv_website, "Website", 0, 500, "", 255, "", "", "")?>
<?=$form->text("Seo title", "inv_title", "inv_title", $inv_title, "Title seo", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Seo desciption", "inv_description", "inv_description", $inv_description, "Des seo", 1, 500, "", 255, "", "", "")?>

<?=$form->close_table();?>
<?=$form->wysiwyg("Chi tiết CĐT", "inv_introduction", $inv_introduction, "../../resource/ckeditor/", "95%", 400)?>
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
<div style="clear: both;"></div>
</body>
</html>