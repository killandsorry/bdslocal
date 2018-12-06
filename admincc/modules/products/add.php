<?
include("inc_security.php");
//Khai báo biến khi thêm mới
$fs_redirect		= "add.php";
$fs_title			= "Dự án"; //tên tiêu đề bân trái
$fs_action			= getURL();//reload lại
$fs_errorMsg		= "";//lỗi trả về nếu thêm mới không đc
$pro_active			= 1;
$pro_name_accent    = '';



$myform	=	new generate_form();//tạo form mới
$myformdes	=	new generate_form();//tạo form mới

$myform->removeHTML(0);
$myformdes->removeHTML(0);
//thêm các trường vào form
$myform->add("pro_name", "pro_name", 0, 0, "", 1, "Chưa nhập tên dự án", 1, "Dự án đã tồn tại"); //tiêu đề tin
$myform->add("pro_name_accent", "pro_name_accent", 0, 1, '', 0, "", 0, ""); //danh mục cấp cha
$myform->add("pro_address", "pro_address", 0, 0, '', 1, "Chưa nhập địa chỉ dự án", 0, ""); //danh mục cấp cha
$myform->add("pro_title", "pro_title", 0, 0, '', 1, "Chưa nhập Seo title", 0, ""); //danh mục cấp cha
$myform->add("pro_description", "pro_description", 0, 0, '', 1, "Chưa nhập Seo description", 0, ""); //danh mục cấp cha
$myform->add("pro_cat_id", "pro_cat_id", 1, 0, 0, 1, "Chưa chọn danh mục", 0, ""); //danh mục cấp cha
$myform->add("pro_cit_id", "pro_cit_id", 1, 0, 0, 1, "Chưa chọn tỉnh/thành", 0, ""); //danh mục cấp cha
$myform->add("pro_district_id", "pro_district_id", 1, 0, 0, 1, "Chưa có quận/huyện", 0, ""); //Ngay dang
$myform->add("pro_invertor_id", "pro_invertor_id", 1, 0, 0, 1, "Chưa có chủ đầu tư", 0, ""); //Ngay dang
$myform->add("pro_design_id", "pro_design_id", 1, 0, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_construction_id", "pro_construction_id", 1, 0, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_active", "pro_active", 1, 1, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_floor", "pro_floor", 1, 0, 0, 1, "Chưa nhập số tầng", 0, ""); //Ngay dang
$myform->add("pro_room", "pro_room", 1, 0, 0, 1, "Chưa nhập số căn hộ", 0, ""); //Ngay dang
$myform->add("pro_teaser", "pro_teaser", 0, 0, '', 1, "Chưa nhập tóm tắt", 0, ""); //Ngay dang
$myform->add("pro_contact", "pro_contact", 0, 0, '', 1, "Chưa nhập liên hệ", 0, ""); //Ngay dang
$myform->add("pro_start_time", "pro_start_time", 0, 0, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_end_time", "pro_end_time", 0, 0, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_price_from", "pro_price_from", 3, 0, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_price_to", "pro_price_to", 3, 0, 0, 0, "", 0, ""); //Ngay dang
$myform->add("pro_status", "pro_status", 1, 0, 0, 0, "", 0, ""); //Ngay dang

//Add table insert data
$myform->addTable($fs_table);

$myformdes->add('prd_id', 'prd_id', 1, 1, 0, 1, 'Chưa thêm được dự án');
$myformdes->add('prd_total', 'prd_total', 6, 0, '', 0, '');
//$myformdes->add('prd_total_img', 'prd_total_img', 0, 1, '', 0, '');

$myformdes->add('prd_position', 'prd_position', 6, 0, '', 0, '');
//$myformdes->add('prd_position_img', 'prd_position_img', 0, 1, '', 0, '');

$myformdes->add('prd_utilities_in', 'prd_utilities_in', 6, 0, '', 0, '');
//$myformdes->add('prd_utilities_in_img', 'prd_utilities_in_img', 0, 1, '', 0, '');
$myformdes->add('prd_utilities_out', 'prd_utilities_out', 6, 0, '', 0, '');
//$myformdes->add('prd_utilities_out_img', 'prd_utilities_out_img', 0, 1, '', 0, '');

$myformdes->add('prd_design', 'prd_design', 6, 0, '', 0, '');
$myformdes->add('prd_price', 'prd_price', 6, 0, '', 0, '');
$myformdes->add('prd_policy', 'prd_policy', 6, 0, '', 0, '');

$myformdes->add('prd_furniture_living_room', 'prd_furniture_living_room', 6, 0, '', 0, '');
$myformdes->add('prd_furniture_bed_room', 'prd_furniture_bed_room', 6, 0, '', 0, '');
$myformdes->add('prd_furniture_wc_room', 'prd_furniture_wc_room', 6, 0, '', 0, '');
$myformdes->add('prd_furniture_logia_room', 'prd_furniture_logia_room', 6, 0, '', 0, '');
$myformdes->add('prd_more', 'prd_more', 6, 0, '', 0, '');
$myformdes->addTable('products_detail');

$pro_name           = getValue('pro_name', 'str', 'POST', '');
$action				= getValue("action", "str", "POST", ""); //kiểm tra xem form có đc submit đi không
//Check $action for insert new data
if($action == "execute"){

    $prd_id = 0;
    if($pro_name != ''){
        $pro_name_accent = removeAccent($pro_name);
    }



    $upload_pro_image = new upload("pro_image",$img_path, $extension_list, 1024);
    if ($upload_pro_image->file_name != ""){
        $pro_image = $upload_pro_image->file_name;
        //$upload_total_img->resize_image($fs_pathfile,$upload_total_img->file_name,300,1000,75, 'small_');
        $myform->add("pro_image","pro_image",0,1,"",0,"",0,"");
    }
    //Check Error!
    $fs_errorMsg .= $upload_pro_image->show_warning_error();

    $upload_total_img = new upload("prd_total_img",$img_path, $extension_list, 1024);
    if ($upload_total_img->file_name != ""){
        $prd_total_img = $upload_total_img->file_name;
        //$upload_total_img->resize_image($fs_pathfile,$upload_total_img->file_name,300,1000,75, 'small_');
        $myformdes->add("prd_total_img","prd_total_img",0,1,"",0,"",0,"");
    }
    //Check Error!
    $fs_errorMsg .= $upload_total_img->show_warning_error();

    $upload_position_img = new upload("prd_position_img",$img_path, $extension_list, 1024);
    if ($upload_position_img->file_name != ""){
        $prd_position_img = $upload_position_img->file_name;
        //$upload_position_img->resize_image($fs_pathfile,$upload_position_img->file_name,300,1000,75, 'small_');
        $myformdes->add("prd_position_img","prd_position_img",0,1,"",0,"",0,"");
    }
    //Check Error!
    $fs_errorMsg .= $upload_position_img->show_warning_error();

    $upload_utilities_in_img = new upload("prd_utilities_in_img",$img_path, $extension_list, 1024);
    if ($upload_utilities_in_img->file_name != ""){
        $prd_utilities_in_img = $upload_utilities_in_img->file_name;
        //$upload_utilities_in_img->resize_image($fs_pathfile,$upload_utilities_in_img->file_name,300,1000,75, 'small_');
        $myformdes->add("prd_utilities_in_img","prd_utilities_in_img",0,1,"",0,"",0,"");
    }
    //Check Error!
    $fs_errorMsg .= $upload_utilities_in_img->show_warning_error();

    $utilities_out_img = new upload("prd_utilities_out_img",$img_path, $extension_list, 1024);
    if ($utilities_out_img->file_name != ""){
        $prd_utilities_out_img = $utilities_out_img->file_name;
        //$utilities_out_img->resize_image($fs_pathfile,$utilities_out_img->file_name,300,1000,75, 'small_');
        $myformdes->add("prd_utilities_out_img","prd_utilities_out_img",0,1,"",0,"",0,"");
    }
    //Check Error!
    $fs_errorMsg .= $utilities_out_img->show_warning_error();

    $fs_errorMsg .= $myform->checkdata();
   
	//thực hiện thêm mới nếu không có lỗi
	if($fs_errorMsg == ""){

        $db_ex   = new db_execute_return();
        $prd_id = $db_ex->db_execute($myform->generate_insert_SQL());
        if($prd_id > 0){

            $db_detail = new db_execute($myformdes->generate_insert_SQL());
            echo "Thêm dự án thành công";
        } else {
            $fs_errorMsg = "Thêm dự án không thành công";
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
<?
//add form for javacheck
$myform->addFormname("add");//(tên form name)
$myform->checkjavascript();

//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$myformdes->evaluate();

$fs_errorMsg .= $myform->strErrorField;
$fs_errorMsg .= $myform->strErrorField;
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
        <?=$form->text('Tên dự án', 'pro_name', 'pro_name', $pro_name, 'Tên dự án', 1, 500, '', 255,'',"placeholder='Sky Central'")?>
        <?=$form->text('Địa chỉ', 'pro_address', 'pro_address', $pro_address, 'Địa chỉ', 1, 500, '', 255,'',"placeholder='176 Định Công, Hoàng Mai'")?>
        <?=$form->text('Title', 'pro_title', 'pro_title', $pro_title, 'Title', 1, 500, '', 255,'',"placeholder='SKY CENTRAL 176 Định Công, Bảng giá, Tiến độ thi công, Tiện ích'")?>
        <?=$form->textarea('Description', 'pro_description', 'pro_description', $pro_description, 'Description', 1, 600, 50)?>

        <?=$form->select('Tỉnh/Thành', 'pro_cit_id', 'pro_cit_id', $arrayCity, $pro_cit_id, 'Tỉnh thành', 1)?>
        <tr>
            <td class="form_name"><font class="form_asterisk">* </font>Quận/Huyện :</td>
            <td class="form_text"  id="load_district">
            </td>
        </tr>
        <?=$form->select('Trạng thái bàn giao', 'pro_status', 'pro_status', $array_prostatus, $pro_status, 'Trạng thái bàn giao nhà', 0, 200)?>
        <?=$form->select('Danh mục', 'pro_cat_id', 'pro_cat_id', $arrayCat_vl, $pro_cat_id, 'Category', 0, 200)?>
        <?=$form->select('Chủ đầu tư', 'pro_invertor_id', 'pro_invertor_id', $arrayInvestor, $pro_invertor_id, 'Chủ đầu tư', 1)?>
        <?=$form->select('Đơn vị thiết kế', 'pro_design_id', 'pro_design_id', $arrayDesign, $pro_design_id, 'Đơn vi thiết kế', 0)?>
        <?=$form->select('Đơn vị thi công', 'pro_construction_id', 'pro_construction_id', $arrayConstruction, $pro_construction_id, 'Đơn vi thi công', 0)?>
        <?=$form->text('Số tầng', 'pro_floor', 'pro_floor', $pro_floor, 'Số tầng', 0, 500, '', 255)?>
        <?=$form->text('Số Căn hộ', 'pro_room', 'pro_room', $pro_room, 'Số căn', 0, 500, '', 255)?>
        <?=$form->textarea('Tóm tắt', 'pro_teaser', 'pro_teaser', $pro_teaser, 'Tóm tắt', 1, 600, 50)?>
        <?=$form->text('Liên hệ', 'pro_contact', 'pro_contact', $pro_contact, 'Liên hệ', 0, 500, '', 255)?>
        <?=$form->text('Ngày Khởi công', 'pro_start_time', 'pro_start_time', $pro_start_time, 'Ngày khởi công', 0, 500, '', 255)?>
        <?=$form->text('Ngày Bàn giao', 'pro_end_time', 'pro_end_time', $pro_end_time, 'Ngày bàn giao', 0, 500, '', 255)?>
        <?=$form->text('Giá từ', 'pro_price_from', 'pro_price_from', $pro_price_from, 'Giá từ', 0, 500, '', 255)?>
        <?=$form->text('Giá đến', 'pro_price_to', 'pro_price_to', $pro_price_to, 'Giá đến', 0, 500, '', 255)?>
        <?=$form->getFile('Ảnh đại diện', 'pro_image', 'pro_image', 'Ảnh đại diện', 0);?>
        <?=$form->getFile('Ảnh tổng quan', 'prd_total_img', 'prd_total_img', 'Ảnh tổng quan', 0);?>
        <?=$form->getFile('Ảnh Vị trí', 'prd_position_img', 'prd_position_img', 'Ảnh vị trí', 0);?>
        <?=$form->getFile('Ảnh tiện ích nội', 'prd_utilities_in_img', 'prd_utilities_in_img', 'Ảnh tiện ích nội', 0);?>
        <?=$form->getFile('Ảnh tiện ích ngoại', 'prd_utilities_out_img', 'prd_utilities_out_img', 'Ảnh tiện ích ngoại', 0);?>

        <?=$form->close_table();?>

        <?=$form->create_table(3,3,'width="100%"');?>
        <?
        // tổng quan
        $form->wysiwyg("Tổng quan", "prd_total", $prd_total, "../../resource/ckeditor/", "80%", 250);

        // vị trí

        $form->wysiwyg("Vị trí", "prd_position", $prd_position, "../../resource/ckeditor/", "80%", 250);

        // tiện ích
        $form->wysiwyg("Tiện ích nội khu", "prd_utilities_in", $prd_utilities_in, "../../resource/ckeditor/", "80%", 250);
        $form->wysiwyg("Tiện ích ngoại khu", "prd_utilities_out", $prd_utilities_out, "../../resource/ckeditor/", "80%", 250);

        // thiết kế
        $form->wysiwyg("Thiết kế", "prd_design", $prd_design, "../../resource/ckeditor/", "80%", 250);

        // giá bán
        $form->wysiwyg("Giá bán", "prd_price", $prd_price, "../../resource/ckeditor/", "80%", 250);

        // chính sách bán hàng
        $form->wysiwyg("Chính sách bán", "prd_policy", $prd_policy, "../../resource/ckeditor/", "80%", 250);

        // nội thất phòng khách
        $form->wysiwyg("Nội thất phòng khách", "prd_furniture_living_room", $prd_furniture_living_room, "../../resource/ckeditor/", "80%", 250);

        // nội thất phòng ngủ
        $form->wysiwyg("Nội thất phòng ngủ", "prd_furniture_bed_room", $prd_furniture_bed_room, "../../resource/ckeditor/", "80%", 250);

        // nội thất phòng wc
        $form->wysiwyg("Nội thất vệ sinh", "prd_furniture_wc_room", $prd_furniture_wc_room, "../../resource/ckeditor/", "80%", 250);

        // nội thất logia
        $form->wysiwyg("Nội thất logia", "prd_furniture_logia_room", $prd_furniture_logia_room, "../../resource/ckeditor/", "80%", 250);

        // thông tin thêm
        $form->wysiwyg("Thông tin thêm", "prd_more", $prd_more, "../../resource/ckeditor/", "80%", 250);


        $form->close_table();

        ?>

        <?=$form->close_table();?>
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
    $(function(){
        $('#pro_cit_id').change(function(){
            $.post(
                'load_district.php',
                {cit_id : $(this).val()},
                function(res){
                    if(res.code == 1){
                        $('#load_district').html(res.html);
                    }else{
                        alert(res.error);
                    }
                },'json'
            )
        })
    });
</script>
</html>