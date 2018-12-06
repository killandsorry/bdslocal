<?
	include("inc_security.php");
	
	//Khai báo biến khi thêm mới
	$fs_title				= "Cấu hình Website";
	$fs_action				= getURL();
	$fs_redirect			= getURL();
	$fs_errorMsg			= "";
	
	//Get data edit
	$record_id				= $lang_id;
	$db_edit					= new db_query("SELECT * FROM " . $fs_table . " WHERE " . $id_field . " = " . $record_id);
	if(mysqli_num_rows($db_edit->result) == 0){
		//Redirect if can not find data
		redirect($fs_error);
	}
	$edit						= mysqli_fetch_array($db_edit->result);
	unset($db_edit);
	
	
	/*
	Call class form:
	add các tên trường trước, sau đó add table sau
	1). Ten truong
	2). Ten form
	3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
	4). Noi luu giu data  0 : post, 1 : variable
	5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
	6). Du lieu nay co can thiet hay khong
	7). Loi dua ra man hinh
	8). Chi co duy nhat trong database
	9). Loi dua ra man hinh neu co duplicate
	
	*/
	$myform = new generate_form();
	$myform->add("con_support_online", "con_support_online", 0, 0, $edit["con_support_online"], 0, "", 0, "");
   $myform->add("con_min_product", "con_min_product", 0, 0, $edit["con_min_product"], 0, "", 0, "");
   $myform->add("con_time_edit_stocks", "con_time_edit_stocks", 0, 0, $edit["con_time_edit_stocks"], 0, "", 0, "");

	//Add table insert data (add sau khi add het các trường để check lỗi)
	$myform->addTable($fs_table);

	$trigger = getValue("deltrigger","str","GET","");
	switch($trigger){
		case "delall":
			dropAllTrigger();
		break;
		case "createall":
			createTriggerHistory("user_products","usp_branch_id","usp_use_parent_id","usp_use_child_id","usp_id");
			createTriggerHistory("user_orders","uso_branch_id","uso_use_parent_id","uso_use_child_id","uso_id","uso_dat_id");
			createTriggerHistory("user_stock","uss_branch_id","uss_use_parent_id","uss_use_child_id","uss_id","uss_dat_id");
		break;
		default:
			if($trigger != ""){
				$db_ex = new db_execute("DROP TRIGGER IF EXISTS " . replaceMQ($trigger));
				unset($db_ex);
			}
		break;
	}
	if($trigger != ""){
		//Redirect after insert complate
		redirect("configuration.php");
	}

	//Get action variable for add new data
	$action					= getValue("action", "str", "POST", "");
	//Check $action for insert new data
	if($action == "execute"){
		
	
		//Check form data
		$fs_errorMsg .= $myform->checkdata();
		
		if($fs_errorMsg == ""){
			
			//Insert to database
			$myform->removeHTML(0);
			$db_update = new db_execute($myform->generate_update_SQL($id_field, $record_id));
			unset($db_update);
			//echo $myform->generate_update_SQL($id_field, $record_id); exit();
			
			//Redirect after insert complate
			redirect($fs_redirect);
			
		}//End if($fs_errorMsg == "")
		
	}//End if($action ==1 "insert")
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? 
$myform->checkjavascript(); 
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
	<p align="center" style="padding-left:10px;">
	<?
	$counter = 0;
	$form = new form();
	$form->create_form("edit", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->text("Số đt hotline", "con_support_online", "con_support_online", $con_support_online, "Hotline", 1, 200, "", 255, "", "", "")?>
   <?=$form->text("Min product", "con_min_product", "con_min_product", $con_min_product, "min product", 1, 200, "", 255, "", "", "")?>
   <?=$form->text("Thời gian tối đa được sửa nhập kho (theo giờ)", "con_time_edit_stocks", "con_time_edit_stocks", $con_time_edit_stocks, "min con_time_edit_stocks", 1, 200, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<tr>
		<td colspan="2" class="form_name" style="background: maroon; color: white; font-weight: bold; text-align: left;">DANH SÁCH TRIGGER HISTORY</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<? $form->create_table();?>
				<?
				$db_select = new db_query("SHOW TRIGGERS");
				$arrayField = array();
				while($row = $db_select->fetch()){
					?>
						<tr>
							<td><?=$row["Trigger"]?></td>
							<td>
								<a onclick="if (confirm('Bạn chắc chắn muốn xóa trigger <?=$row["Trigger"]?>?')){ window.location.href='configuration.php?deltrigger=<?=$row["Trigger"]?>' }" href="#" class="delete"><img border="0" src="../../resource/images/grid/delete.gif"></a>
							</td>
						</tr>
					<?
				}
				unset($db_select);
				?>
			<? $form->close_table();?>
		</td>
	</tr>
	<?=$form->button("button" . $form->ec . "reset", "button" . $form->ec . "reset", "button" . $form->ec . "button", "Delete all" . $form->ec . "Create all", "Delete all" . $form->ec . "Create all", 'onclick="if (confirm(\'Bạn chắc chắn muốn xóa tất cả trigger?\')){ window.location.href=\'configuration.php?deltrigger=delall\' }" style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'onclick="if (confirm(\'Bạn chắc chắn muốn tạo mới tất cả trigger?\')){ window.location.href=\'configuration.php?deltrigger=createall\' }" style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
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