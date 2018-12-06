<?
include("../../../../../../../classes/upload.php");
include("../../../../../../../functions/functions.php");
$filepath = "images/";
$extension_list = "jpg,png,bmp,jpeg";
$errorMsg	=	"";
$filename = new upload("NewFile", $filepath, $extension_list, 2000);
$errorMsg = $filename->warning_error;
if($errorMsg != ""){
	?>
	<script>alert('<?=$errorMsg?>');</script>
	<?
} else {
?>
<script>
	alert('Upload ảnh thành công!');
	window.parent.cancel();
	Cancel();
</script>
<?
}
?>
