<?
include 'config.php';

// current url
$url		= '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$page_url	= '';
$currentUrl		= explode(',', $_SERVER['REQUEST_URI']);
if(isset($currentUrl[0])) $page_url	= $currentUrl[0];
// get id
$cat_id     = getValue('cat_id', 'int', 'GET', 0);

if($cat_id <= 0 || $cat_id > 90000){
    header_301(PATH_ROOT);
    exit();
}

// lấu thông tin category để hiển thị seo
$db_cat     = new db_query("SELECT * FROM categories WHERE cat_id = " . intval($cat_id) . " LIMIT 1");
if($rcat    = $db_cat->fetch()){

}else{
    header_301(PATH_ROOT);
    exit();
}
unset($db_cat);

/** Phần lấy thông tin phân trang  */
// page number thực hiện phân trang
$page		= getValue('page', 'int', "GET", 1);

if($page < 1) $page = 1;
if($page > 10) $page = 1;

$page_size	= 10;

$db_count		= new db_count("SELECT COUNT(*) AS count FROM news
									WHERE 1 AND new_active = 1 AND new_cat_id = " . intval(($cat_id)));
$total_record	= $db_count->total;
unset($db_count);


$page_prefix		    = "";
$normal_class		    = "page";
$selected_class	        = "page_current";
$previous			    = "<";
$next					= ">";
$first				    = "<<";
$last					= ">>";
$break_type			    = 1;

if($total_record % $page_size == 0) $num_of_page = $total_record / $page_size;
else $num_of_page = (int)($total_record / $page_size) + 1;
$limit	= " LIMIT " . ($page - 1) * $page_size . "," . $page_size;




$title          = $rcat['cat_name'];
$description    = $rcat['cat_description'];


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
        include '../includes/inc_news_list.php';
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