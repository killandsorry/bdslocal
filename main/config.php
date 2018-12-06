<?php
require_once '../variables/config.php';

// current url
$http           = isset($_SERVER['REQUEST_SCHEME'])? $_SERVER['REQUEST_SCHEME'] : 'http';
$server_name    = isset($_SERVER['SERVER_NAME'])? $_SERVER['SERVER_NAME'] : 'bds.com';
$uri            = isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI'] : '';

// $path_root domain
define('PATH_ROOT', '/');

$con_current_url    = $http . '://' . $server_name . $uri;

// site name - abstract
$year           = date('Y', time() + 90*86400);
$con_site_name      = 'Mua Bán Chung cư, Đất nền, Biệt thự, Nhà đất - Uy Tín - Cập nhật ' . $year;
$con_copyright      = 'Copyright © '. $year .' by '. $server_name;

