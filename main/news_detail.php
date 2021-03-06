<?
include 'config.php';

// get id
$new_id     = getValue('id', 'int', 'GET', 0);

// lấy thông tin sản phẩm
$db_new = new db_query("SELECT * FROM  news
                        INNHER JOIN news_content ON new_id = nec_id
                        WHERE new_id = ". intval($new_id) ."
                        LIMIT 1");
if($row = $db_new->fetch()){

}else{
    die('Không tồn tại dự án này');
}
unset($db_new);

$new_name = $row['new_name'];

$title          = $row['new_title'];
$description    = $row['new_description'];


?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?=$title?></title>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html" />
    <meta http-equiv="content-language" itemprop="inLanguage" content="vi"/>
    <meta name="description" itemprop="description" content="<?=$description?>" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1.0, minimum-scale=1.0">
    <meta property="og:site_name" content="<?=$con_site_name?>" />
    <meta property="og:type" content="Website" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:title" itemprop="name" content="<?=$title?>" />
    <meta property="og:url" itemprop="url" content="<?=$con_current_url?>" />
    <meta property="og:description" content="<?=$description?>" />
    <meta property="og:image"  content=""  />
    <meta property="fb:page_id" content="" />
    <meta property="fb:app_id" content="" />
    <meta name="language" content="vietnamese" />
    <meta name="copyright" content="<?=$con_copyright?>" />
    <meta name="abstract" content="<?=$con_site_name?>" />
    <meta name="distribution" content="Global" />
    <meta name="author" itemprop="author" content="<?=$server_name?>" />
    <meta http-equiv="refresh" content="1800" />
    <meta name="REVISIT-AFTER" content="1 DAYS" />
    <link rel="canonical" href="<?=$con_current_url?>"/>
    <link rel='shortcut icon' type='image/png' href='/favicon.png' />
    <?
    include '../variables/common_header.php';
    ?>
</head>
<body>
<div id="header">
    <?
    include '../includes/inc_header.php';
    ?>
</div>
<div id="main_container">
    <?
    include '../includes/inc_news_detail.php';
    ?>
</div>
<div id="footer">
    <?
    include '../includes/inc_footer.php';
    ?>
</div>

<?
include '../variables/common_footer.php';
?>
<?
echo $load_css_after;
?>
</body>
</html>