<?
require_once("inc_security.php");
$list = new fsDataGird($id_field,$name_field,translate_text("Product listing"));
$list->page_size = 200;

$pro_name					= getValue("pro_name","str", "GET", "");


/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/

//$list->add("pro_picture", "Picture", "int", 1, 0);
$list->add("",translate_text("Edit"),"edit");
$list->add("pro_name", "Dự án", "str", 0, 0);
$list->add("pro_address", "Địa chỉ", "str", 0, 0);
$list->add("pro_title", "Tiêu đề", "str", 0, 0);
$list->add("pro_description", "Description", "str", 0, 0);
$list->add('pro_start_time','Thời gian', 'str', 0, 0);
$list->add('pro_price_to','Giá', 'str', 0, 0);
$list->add("pro_floor", "Số tầng", "str", 0, 0);
$list->add("pro_room", "Số phòng", "int", 0, 0);
$list->add("pro_teaser", "Tóm tắt", "str", 1, 0);
$list->add("pro_active", "Hoạt động", "int", 1, 0);

//add 2 ô tìm kiếm theo ngày
$list->addSearch("Dự án","pro_name", "text",$pro_name,translate_text("Enter keyword"));
$list->add("",translate_text("Delete"),"delete");
$list->ajaxedit($fs_table);

$sql 						= " ";
if($pro_name != "" && $pro_name != translate_text("Enter keyword")){
    $sql .= " AND pro_name LIKE '%" . $pro_name . "%'";
}

//Lấy dữ liệu
$total			= new db_count("SELECT 	count(*) AS count
										 FROM " . $fs_table . "
										 WHERE 1 " . 	$sql); // AND

$db_listing 	= new db_query("SELECT *
										 FROM " . $fs_table . "
										 WHERE 1 ".  $sql . $list->limit($total->total));
$total_row		= 	$total->total;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?=$list->headerScript()?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<!--<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
<input type="hidden" name="iQuick" value="update" />-->

<div id="listing">
  <?=$list->showHeader($total_row)?>
<input type="hidden" class="iCat" id="iCat" name="iCat" value="0" />
<script>
/*==================================================================================*/
$("#pro_name").autoSuggest('/ajax/autocomplete.php', {
   minChars : 1,
   selectionLimit : 1,
   selectedItemProp : 'p_text',
   searchObjProps : 'p_text',
   selectedItemiCat: 'iCat',
   startText: '',
   retrieveLimit : 15,
   formatList : function(data, el) {
      var html = formatResults(data);
      el.html(html);
      $('.as-list').append(el);
   },
   retrieveComplete: function(data) {
      return data.result;
   }
});
</script>
  <?
  	$i = 0;
	while($row	=	mysqli_fetch_assoc($db_listing->result)){
  		$i++;
		?>

        <?=$list->start_tr($i, $row['pro_id'])?>
        <?=$list->showEdit($row['pro_id'])?>
        <td><b><?=$row['pro_name']?></b></td>
        <td><b><?=isset($row['pro_address'])? $row['pro_address'] : ''?></b></td>
        <td><b><?=isset($row['pro_title'])? $row['pro_title'] : ''?></b></td>
        <td><b><?=isset($row['pro_description'])? $row['pro_description'] : ''?></b></td>
        <td>
            Ngày KC: <b><?=$row['pro_start_time']?></b><br/>
            Ngày BG: <b><?=$row['pro_end_time']?></b>
        </td>
        <td>
            Giá từ: <b><?=$row['pro_price_from']?></b><br/>
            Giá đến: <b><?=$row['pro_price_to']?></b>
        </td>
        <td><b><?=isset($row['pro_floor'])? $row['pro_floor'] : ''?></b></td>
        <td><b><?=isset($row['pro_room'])? $row['pro_room'] : ''?></b></td>
        <td><b><?=isset($row['pro_teaser'])? $row['pro_teaser'] : ''?></b></td>
        <td width="120" align="center"><a onClick="loadactive(this); return false;" href="active.php?record_id=<?=$row["pro_id"]?>&type=pro_active&value=<?=abs($row["pro_active"]-1)?>&url=<?=base64_encode(getURL())?>"><img border="0" src="<?=$fs_imagepath?>check_<?=$row["pro_active"];?>.gif" title="Đưa thuốc vào phần gợi ý thuốc!" /></a></td>
        <?=$list->showDelete($row['pro_id'])?>
        <?=$list->end_tr()?>
		<?
  	}
	  unset($db_listing);
  ?>
  <?=$list->showFooter($total_row)?>
</div>
<!--</form>-->
<? /*---------Body------------*/ ?>
<script>
	function deletefile(id,file){
	$("#tr_"+id).remove();
	$.ajax({
		type: "POST",
		url: "delete.php",
		data: {record_id:id,
		file:	file},
		success: function(msg){
		  if(msg!=''){
		  	alert( msg );
		  }
		}
	 });
	}
</script>
</body>
</html>