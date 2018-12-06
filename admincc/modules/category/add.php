<?

require_once("inc_security.php");


	//Khai bao Bien
	$fs_redirect							= "add.php";
	$after_save_data						= getValue("after_save_data", "str", "POST", "add.php");
	$cat_type								= getValue("cat_type","str","GET","");
	if($cat_type == "") $cat_type 	= getValue("cat_type","str","POST","");
	$sql										= "1";
	if($cat_type != "")  $sql			= " cat_type = '" . $cat_type . "'";
	
	//Call Class generate_form();
	$myform 									= new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
	/**
	1). $data_field			: Ten truong
	2). $data_value			: Ten form
	3). $data_type				: Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
	4). $data_store			: Noi luu giu data  0 : post, 1 : variable
	5). $data_default_value	: Gia tri mac dinh, neu require thi phai lon hon hoac bang default
	6). $data_require			: Du lieu nay co can thiet hay khong
	7). $data_error_message	: Loi dua ra man hinh
	8). $data_unique			: Chi co duy nhat trong database
	9). $data_error_message2: Loi dua ra man hinh neu co duplicate
	10). $type_form: kiểu form : 1 text ; 2 textarea; 3 kiểu checkbook
	*/
   
	$myform->add("cat_type","cat_type",0,0,$cat_type,1,("Vui lòng chọn loại danh mục!"),0,"");
	$myform->add("cat_name","cat_name",0,0,"",1,("Vui lòng nhập tên danh mục"),0,"");
	$myform->add("cat_active","active",1,1,1,0,"",0,"");
	$myform->addTable($fs_table);
	//Warning Error!
	$errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
	if($action == "execute"){
		$errorMsg .= $myform->checkdata();
		if($errorMsg == ""){
			$db_ex 	= new db_execute_return();
			//echo $myform->generate_insert_SQL();
			$last_id = $db_ex->db_execute($myform->generate_insert_SQL());
			//echo $myform->generate_insert_SQL();
			// Redirect to add new
			$fs_redirect = "add.php?save=1&cat_type=" . getValue("cat_type","str","POST");
			//Redirect to:
			redirect($fs_redirect);
			exit();
		}
	}
	//add form for javacheck
	$myform->addFormname("add_new");
	$myform->evaluate();
	   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? $myform->checkjavascript();?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top(("Add_new_category"))?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($errorMsg)?>
	<tr> 
		<td align="right" nowrap class="form_name" width="200"><font class="form_asterisk">* </font> <?=translate_text("Loại danh mục")?> :</td>
		<td>
			<select name="cat_type" id="cat_type"  class="form_control" onChange="window.location.href='add.php?cat_type='+this.value">
				<option value="hieu">--[ <?=translate_text("Chọn loại danh mục")?> ]--</option>
				<?
					foreach($array_type_cat as $key => $value){
				?>
				<option value="<?=$key?>" <? if($key == $cat_type) echo "selected='selected'";?>><?=$value?></option>
				<? } ?>
			</select>
		</td>
	</tr>	
	<?=$form->text("Tên danh mục", "cat_name", "cat_name", $cat_name, "Tên danh mục", 1, 250, "", 255, "", 'onblur="$(\'#cat_rewrite\').val($(this).val())"', "")?>	
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>
	</p>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>