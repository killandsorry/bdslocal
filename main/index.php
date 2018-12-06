<?
require_once 'config.php';

$title      = '';
$keyword    = '';
$description    = '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title><?=$title?></title>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html" />
    <meta http-equiv="content-language" itemprop="inLanguage" content="vi"/>
    <meta name="keywords" itemprop="keywords" content="<?=$keyword?>" />
    <meta name="description" itemprop="description" content="<?=$description?>" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1.0, minimum-scale=1.0">
    <meta property="og:site_name" content="Mạng tuyển dụng, Tìm việc làm online" />
    <meta property="og:type" content="Website" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:title" itemprop="name" content="<?=$title?>" />
    <meta property="og:url" itemprop="url" content="" />
    <meta property="og:description" content="<?=$description?>" />
    <meta property="og:image"  content=""  />
    <meta property="fb:page_id" content="" />
    <meta property="fb:app_id" content="" />
    <meta name="language" content="vietnamese" />
    <meta name="copyright" content="Copyright © 2018 by 1viec.com" />
    <meta name="abstract" content="1viec.com Tìm việc làm, Tuyển dụng nhân sự việt, Tìm kiếm tài năng việt" />
    <meta name="distribution" content="Global" />
    <meta name="author" itemprop="author" content="1viec.com" />
    <meta http-equiv="refresh" content="1800" />
    <meta name="REVISIT-AFTER" content="1 DAYS" />
    <link rel="canonical" href="//1viec.com"/>
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
        include '../includes/inc_main_container.php';
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