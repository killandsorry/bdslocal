<?
require_once("inc_security.php");
$list = new fsDataGird($id_field,$name_field,translate_text("Product listing"));
$keyword					= getValue("use_login","str", "GET", "");
//$pro_cat_id				= getValue("pro_cat_id","int", "GET", 0);

/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/

//$list->add("pro_picture", "Picture", "int", 1, 0);
$list->add("use_name", "Tên", "str", 1, 1);
$list->add("use_login", "Tài khoản", "str", 1, 1);
$list->add("use_phone", "Số ĐT", "str", 1, 1);
$list->add("use_supplier", "CTV", "str", 1, 1);
$list->add("use_contact", "Liên hệ gần nhất", "str", 1, 1);
$list->add("use_date", "Ngày tạo", "int", 1, 0);
$list->add("use_date_expires", "Ngày hết hạn", "int", 1, 0);
$list->add("use_payment", "Trả phí", "int", 1, 1);
$list->add("use_right", "Tài khoản con", "int", 0, 0);
$list->add("use_branch", "Chi nhánh", "str", 0, 0);
$list->add("use_login", "Fake Login", "str", 0, 0);
$list->add("use_login", "Fake Debug", "str", 0, 0);

//add 2 ô tìm kiếm theo ngày
$list->addSearch("Tài khoản","use_login", "text",$keyword,translate_text("Enter keyword"));

//$list->add("",translate_text("Copy"),"copy");
$list->add("",translate_text("Edit"),"edit");
$list->ajaxedit($fs_table);

//câu sql where ngày tạo hiển thị lớn hơn từ ngày và nhở hơn đến ngày
$sql 						= " ";
if($keyword != "" && $keyword != translate_text("Enter keyword")){
	$sql .= " AND (use_login LIKE '%" . replaceMQ($keyword) . "%' OR use_fullname LIKE '%" . replaceMQ($keyword) . "%' OR use_phone LIKE '%" . replaceMQ($keyword) . "%')";
}

$sql .= " AND use_id = use_parent_id ";
$short   = " ORDER BY use_id DESC ";
//echo $sql;
//Lấy dữ liệu
$total			= new db_count("SELECT 	count(*) AS count
										 FROM " . $fs_table . "
										 WHERE 1 " . $sql); // AND

$db_listing 	= new db_query("SELECT *
										 FROM " . $fs_table . "
										 WHERE 1 ".  $sql . $short .  $list->limit($total->total));
$total_row		= 	$total->total;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?=$list->headerScript()?>
<style>
   .v{
      background-color: #ffffa6 !important;
   }
   .show_list{
      background-color: #fff;
      line-height: 15px;
      list-style: outside none a;
      margin: 5px 0;
      padding: 5px 5px 5px 20px;
   }
   .status_btn{
   border: 1px solid #ccc;
   padding: 3px 5px;
   text-align: center;
   font-size: 11px;
   border-radius: 3px;
   background-color: #f9f9f9;
   color: #555;
   cursor: pointer;
   white-space: nowrap;
}
.bg_rez{
   
}
.bg_mov{
   background-color: #FFFFAA;
   border-color: #FAE287;
}
.bg_acc{
   background-color: #27ae60;
   border-color: #209923;
   color: #fff;
}
.bg_can{
   background-color: #FF5353;
   border-color: #FF0909;
   color: #fff;
}
#history_im_ex{
   position: fixed;
   z-index: 1000;
   top: 5%;
   left: 5%;
   width: 90%;
   background-color: #fff;
   height: 90%;
}
.hide{
   display: none;
}
</style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<!--<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
<input type="hidden" name="iQuick" value="update" />-->

<div id="listing">
  <?=$list->showHeader($total_row)?>
<input type="hidden" class="iCat" id="iCat" name="iCat" value="0" />

  <?
  	$i = 0;
	while($row	=	mysqli_fetch_assoc($db_listing->result)){
  		$i++;
      $cl   = ($row['use_date_expires'] > time())? '' : 'v';
		?>

			<?=$list->start_tr($i, $row['use_id'],'class="'. $cl .'"')?>
			<td><b><?=$row['use_fullname']?></b></td>
         <td><b><?=$row['use_login']?></b></td>
         <td><b><?=$row['use_phone']?></b></td>
         <td align="center"><a onClick="loadactive(this); return false;" href="active.php?record_id=<?=$row["use_id"]?>&type=use_supplier&value=<?=abs($row["use_supplier"]-1)?>&url=<?=base64_encode(getURL())?>"><img border="0" src="<?=$fs_imagepath?>check_<?=$row["use_supplier"];?>.gif" title="Người dùng cộng tác viên" /></a></td>
         <td style="text-align: center;">
            <?
            if($row['use_contact'] > 0){
               echo date('H:i - d/m/Y', $row['use_last_contact']);
               echo '<p><span class="status_btn bg_acc" data-id="'. $row['use_id'] .'" onclick="detail_contact('. $row['use_id'] .')">Xem và thêm LH</span></p>';
            }else{
               echo '<p><span class="status_btn bg_can" data-id="'. $row['use_id'] .'" onclick="detail_contact('. $row['use_id'] .')">Chưa LH</span></p>';
            }
            ?>
         </td>
         <td style="text-align: center;"><?=($row['use_date'] > 0)? date('H:i - d/m/Y', $row['use_date']) : ''?></td>
         <td style="text-align: center;">
            <b style="color: <?=($row['use_date_expires'] > time())? '#47A447' : '#f00'?>"><?=($row['use_date_expires'] > 0)? date('d/m/Y', $row['use_date_expires']) : ''?></b>
         </td>
			<td align="center">
            <?
            echo ($row['use_payment'] > 0)? '<img src="../../../themes/image/payment.png" />' : 'Dùng thử';
            ?>
         </td>
         <td>
            <span id="title_user_<?=$row['use_id']?>" style="cursor: pointer;" onclick="show_user(<?=$row['use_id']?>);">[+] Ẩn/Hiện tài khoản con</span>
            <div id="user_<?=$row['use_id']?>"></div>
         </td>
         <td>
            <span id="title_branch_<?=$row['use_id']?>" style="cursor: pointer;" onclick="show_branch(<?=$row['use_id']?>)">[+] Ẩn/Hiện chi nhánh</span>
            <div id="branch_<?=$row['use_id']?>"></div>
         </td>
         <td>
            <a target="_blank" href="/banhang/fakelogin.php?<?=crateUrlToken(array("loginname" => $row['use_login']),0)?>">Fake login</a>
         </td>
         <td>
            <a target="_blank" href="/banhang/fakelogin.php?<?=crateUrlToken(array("loginname" => $row['use_login'],"dev"=>1),0)?>">Fake Debug</a>
         </td>
			<?=$list->showEdit($row['use_id'])?>
			<?=$list->end_tr()?>
		<?
  	}
	  unset($db_listing);
  ?>
  <?=$list->showFooter($total_row)?>
  <div class="hide" id="history_im_ex"></div>
</div>
<!--</form>-->
<? /*---------Body------------*/ ?>
<script>
	function deletefile(id){
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
   
   function show_user(id){
      if(id <= 0) return false;
      if($('#user_'+id).html() != ''){
         $('#user_'+id).toggle();
      }
      $.post(
         'show_user_child.php',
         {uid : id},
         function(res){
            if(res.status == 0){
               alert( 'Không có dữ liệu' );
            }else{
               $('#user_'+id).html(res.data);
            }
         },
         'json'
      );
	}
   
   function show_branch(id){
      if(id <= 0) return false;
      if($('#branch_'+id).html() != ''){
         $('#branch_'+id).toggle();
      }
      $.post(
         'show_branch.php',
         {bid : id},
         function(res){
            if(res.status == 0){
               alert( 'Không có dữ liệu' );
            }else{
               $('#branch_'+id).html(res.data);
            }
         },
         'json'
      );
	}
   
   function detail_contact(id){
      
      if(id <= 0) return false;
         
      var elm = $('#history_im_ex');        
      $('#ovl_alert').removeClass('hide');
      elm.html('<iframe style="width: 100%;height: 100%;border: none;" src="/banhang/detail_contact.php?u_id='+id+'"></iframe>');
      elm.removeClass('hide');
   }
   
   function close_history(){
      $('#history_im_ex').addClass('hide').html('');
   }
</script>
</body>
</html>