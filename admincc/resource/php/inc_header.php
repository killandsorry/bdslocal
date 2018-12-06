<?
require_once("../classes/database.php");
require_once("../functions/functions.php");
$isAdmin = isset($_SESSION["isAdmin"]) ? intval($_SESSION["isAdmin"]) : 0;

?>
<div class="header">
	<table cellpadding="0" cellspacing="0"  width="100%">
		<tr>
			<td style="font-size:14px;">Hệ thống quản trị website</td>
			<td align="right">
				
				
				<a href="#">Hi! <span id="acc_name"><?=getValue("userlogin","str","SESSION","")?></span></a> 
				&nbsp;|&nbsp;
				<span id="acc1" class="infoacc"><?=translate_text("Thông tin tài khoản")?><span class="sourceacc" style="display: none;">resource/profile/myprofile.php</span></span>
				&nbsp;|&nbsp;
				<?
				//kiem tra xem neu la o tren localhost thi moi co quyen cau hinh
				$url = $_SERVER['SERVER_NAME'];
				if($isAdmin==1 && ($url == "localhost" || strpos($url,"192.168.1")!==false)){
				?>
				<span id="acc2" class="infoacc"><?=translate_text("Website Settings")?><span class="sourceacc" style="display: none;">resource/configadmin/configmodule.php</span></span> 
				&nbsp;|&nbsp;
				<?
				}
				?>
				<a href="resource/logout.php"><?=translate_text("Logout")?></a>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>