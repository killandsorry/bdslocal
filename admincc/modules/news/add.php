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
$new_date			= time();
$new_active         = 1;


#+
#+ Goi class generate form
$myform = new generate_form();	//Call Class generate_form();
#+ Khai bao thong tin cac truong
$myform->add("new_name", "new_name", 0, 0, '', 1, "Bạn chưa nhập tiêu đề", 0, "");
$myform->add("new_cat_id", "new_cat_id", 1, 0, 0, 0, "Bạn chưa chọn danh mục", 0, "");
$myform->add("new_pro_id", "new_pro_id", 1, 0, 0, 0, "", 0, "");
$myform->add("new_title", "new_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề.", 0, "");
$myform->add("new_description", "new_description", 0, 0, '', 1, "Tóm tắt.", 0, "");

$myform->add("new_date", "new_date", 1, 1, 0, 0, "", 0, "");
$myform->add("new_active", "new_active", 1, 1, 0, 0, "", 0, "");
$myform->addTable($fs_table);


$nec_content	= getValue('nec_content', 'str', 'POST', '');


$nec_content	= str_replace('http://%5C%22', '', $nec_content);
$nec_content	= str_replace('%5C%22', '', $nec_content);
$nec_content	= str_replace('%22', '', $nec_content);
$nec_content	= str_replace('http://http://', 'http://', $nec_content);
$nec_content	= str_replace('http://https://', 'https://', $nec_content);



$mydes	= new generate_form();
$mydes->add('nec_id', 'nec_id', 1, 1, 0, 1, 'Chưa thêm nội dung thành công');
$mydes->add('nec_content', 'nec_content', 6, 1, '', 1, 'Chưa nhập nội dung chi tiết', 0, '');
$mydes->add('nec_source', 'nec_source', 0, 0, '', 0, '', 0, '');
$mydes->addTable('news_content');

#+
#+ đổi tên trường thành biến và giá trị
$myform->evaluate();
$mydes->evaluate();

#+
#+ Neu nhu co submit form
if($action == "submitForm"){
	$upload_pic = new upload("new_image",$fs_pathfile, $extension_list, 500);
	if ($upload_pic->file_name != ""){
		$new_image = $upload_pic->file_name;
		$upload_pic->resize_image($fs_pathfile,$upload_pic->file_name,200,1000,75, 'small_');
        $myform->add("new_image", "new_image", 0, 1, '', 0, "", 0, "");
	}
	//Check Error!
	$errorMsg .= $upload_pic->show_warning_error();
	#+
	#+ Kiểm tra lỗi
   $errorMsg .= $myform->checkdata();
	# $errorMsg .= $myform->strErrorField ;	//Check Error!
	if($errorMsg == ""){
		#+ Thuc hien query
		$db_ex	 		= new db_execute_return();
		$query			= $myform->generate_insert_SQL();
		$nec_id 		= $db_ex->db_execute($query);
		if($nec_id > 0){
			$errorMsg	= $mydes->checkdata();
			if($errorMsg == ''){

				$db_ex	= new db_execute($mydes->generate_insert_SQL());
				unset($db_ex);
				redirect($add);
			}
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
<?=$form->text("Tên bài viết", "new_name", "new_name", $new_name, "Tiêu đề", 1, 500, "", 255, "", "", "")?>
<?=$form->text("Tiêu đề", "new_title", "new_title", $new_title, "Tiêu đề", 1, 500, "", 255, "", "", "")?>
<?=$form->textarea('Tóm tắt', 'new_description', 'new_description', $new_description, 'Tóm tắt', 1, 500, 100)?>
<?=$form->select('Danh mục', 'new_cat_id', 'new_cat_id', $arrayCat_vl, $new_cat_id, 'Category', 0, 200)?>
<?=$form->select('Dự án', 'new_pro_id', 'new_pro_id', $arrrayProducts, $new_pro_id, 'Category', 0, 200)?>
<?=$form->getFile("Ảnh tiêu đề", 'new_image', 'new_image', 'ảnh tiêu đề', 1)?>
<?=$form->text("Nguồn", "nec_source", "nec_source", $nec_source, "Nguồng", 1, 500, "", 255, "", "", "")?>
<?=$form->close_table();?>
<?

$form->wysiwyg("Nội dung", "nec_content", $nec_content, "../../resource/ckeditor/", "80%", 250);
?>

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