<?
	include "inc_security.php";	
	//Kiem tra quyen them sua xoa
	checkAddEdit("add");
	
	$fs_errorMsg	= "";
	$new_date		= time();
	$new_active		= 0;
	
	$myform	=	new generate_form();
	$myform->add('new_cat_id', 'new_cat_id', 1, 0, '', 1, 'Bạn chưa chọn danh mục', 0, '');
	$myform->add('new_title', 'new_title', 0, 0, '', 1, 'Bạn chưa nhập tiêu đề tin', 0, "");
	$myform->add('new_domain', 'new_domain', 0, 0, '', 1, 'Bạn chưa nhập domain', 0, '');	
	$myform->add("new_date", "new_date", 1, 1, 0, 0, "", 0, "");
	$myform->add("new_active", "new_active", 1, 0, 0, 0,"",0,"");
	$myform->addTable($fs_table);
	
	$action			= getValue("action", "str", "POST", "");
	if($action 		== 'execute'){
		//Check form data
		$fs_errorMsg .= $myform->checkdata();
		
		if($fs_errorMsg == ""){
			$upload		= new upload($fs_fieldupload, $fs_filepath, $fs_extension, $fs_filesize);
			$filename	= $upload->file_name;
			if($filename != ""){				
				$myform->add("new_picture", "filename", 0, 1, "", 0, "", 0, "");
			}
			$fs_errorMsg .= $upload->show_warning_error();
			
			if($fs_errorMsg == ""){
				
				$db_insert 		= new db_execute_return();
				$last_id			= $db_insert->db_execute($myform->generate_insert_SQL());
				unset($db_insert);
				
				if($last_id > 0){
					echo $last_id;
					$content		= getValue('ned_detail', 'str', 'POST', '');
					$ned_search	= removeHTML($content);
					
					$myform_des		=	new generate_form();
					$myform_des->add("ned_new_id", "last_id", 1, 1, 0);
					$myform_des->add("ned_teaser", "ned_teaser", 0, 0, 0);
					$myform_des->add("ned_search", "ned_search", 0, 0, 0);
					$myform_des->add("ned_detail", "ned_detail", 0, 0, 0);
					$myform_des->addTable("news_description");
					$myform_des->removeHTML(0);
					
					$fs_errorMsg	.=	$myform_des->checkdata();
					if($fs_errorMsg == ""){
						$db_insert	=	new db_execute($myform_des->generate_insert_SQL());
						if($db_insert->total <= 0){
							$db_del	= new db_execute("DELETE FROM news WHERE new_id = ". $last_id, __FILE__ . " Line: " . __LINE__);
							unset($db_del);
							$db_insert_view	=	new db_execute("INSERT INTO news_visit (nev_new_id,nev_count) VALUES (".$last_id.", 0 )");
							unset($db_insert_view);
						}else{
							unset($db_insert);
							redirect("add.php");
						}
					}
				}
				
				
			}
		}
	}
	
	$menu 	= new menu();
	$listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0","cat_type = 'news' AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
	$myform->addFormname("add_new");
	$myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?=$load_header?>
<link rel="stylesheet" href="autocomplete/token-input-facebook.css" media="screen"/>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="autocomplete/jquery.tokeninput.js"></script>

<? $myform->checkjavascript();?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<?=template_top(translate_text("Add merchant"))?>
	<p align="center" style="padding-left:10px;">
		<?
		$form = new form();
		$form->create_form("add_new",'',"post","multipart/form-data","onsubmit='validateForm(); return false;'");
		$form->create_table();		
		?>
		<?=$form->text_note('Những ô dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
		<? //Khai bao thong bao loi ?>
		<?=$form->errorMsg($fs_errorMsg)?>
		<?=$form->select_db_multi("Danh mục", "new_cat_id", "new_cat_id", $listAll, "cat_id", "cat_name", $new_cat_id, "Danh mục", 1, "150", 1, 0, "", "")?>
		<?=$form->text("Domain lấy tin", "new_domain", "new_domain", $new_domain, "Domain lấy tin", 1, 200)?>
		<?=$form->text("Tiêu đề", "new_title", "new_title", $new_title, "Tiêu đề tin", 1, 350)?>
		<?=$form->getFile("Ảnh đại diện", $fs_fieldupload, $fs_fieldupload, "Ảnh đại diện của tin", 0, 30, "", "")?>		
		<?=$form->textarea("Tóm tắt", "ned_teaser", "ned_teaser", getValue("ned_teaser", "str", "POST", ""), "Tóm tắt của tin", 1, 600, 50)?>
		<?=$form->close_table();?>
		<?=$form->wysiwyg("Bài viết", "ned_detail", getValue("ned_detail", "str", "POST", ""), "../../resource/wysiwyg_editor/", "99%", 450)?>
		<?=$form->create_table();?>		
		<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
		<?=$form->hidden("action", "action", "execute", "");?>
		<?
		$form->close_table();
		$form->close_form();
		unset($form);
		?>
	 </p>
<?=template_bottom() ?>

</body>
</html>