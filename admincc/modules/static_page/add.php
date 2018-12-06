<?
require_once("inc_security.php");
#+
#+ Khai bao bien
$add				= "add.php";
$listing			= "listing.php";
$edit				= "edit.php";
$after_save_data	= getValue("after_save_data", "str", "POST", $listing);

$errorMsg 			= "";		//Warning Error!
$action				= getValue("action", "str", "POST", "");
$fs_action			= getURL();
$sta_date			= time();


$sta_content	= getValue('sta_content', 'str', 'POST', '');
//$html_clean			= new html_cleanup($sta_content);
//$html_clean->clean();
//$sta_content	= $html_clean->output_html;

$sta_content	= str_replace('http://%5C%22', '', $sta_content);
$sta_content	= str_replace('%5C%22', '', $sta_content);
$sta_content	= str_replace('%22', '', $sta_content);
$sta_content	= str_replace('http://http://', 'http://', $sta_content);

#+
#+ Goi class generate form
$myform = new generate_form();	//Call Class generate_form();
#+ Khai bao thong tin cac truong
$myform->add("sta_title", "sta_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề.", 0, "");
$myform->add('sta_content', 'sta_content', 6, 1, '', 1, 'Chưa nhập nội dung chi tiết', 0, '');
$myform->add("sta_date", "sta_date", 1, 1, 0, 0, "", 0, "");
$myform->addTable($fs_table,DB_BLOG);


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
		$query			= $myform->generate_insert_SQL();
		$hel_id 		= $db_ex->db_execute($query,__FILE__, DB_BLOG);
		if($hel_id > 0){
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
<?=$form->text("Tiêu đề", "sta_title", "sta_title", $sta_title, "Tiêu đề", 1, 500, "", 255, "", "", "")?>
<?=$form->close_table();?>
<?=$form->wysiwyg("Mô tả chi tiết", "sta_content", $sta_content, "../../resource/ckeditor/", "95%", 300)?>
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