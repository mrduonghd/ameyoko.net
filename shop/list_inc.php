<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/shop/shop.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/Common_function.php");

$category_shop = array("all","fashion","shoes_bag_accessorie","gourmet","food","sundry_goods","cosme_drag","leisure_other");
$online = array("yes","no");


if (isset($_GET['category']) && isset($_GET['online']) && in_array($_GET['category'],$category_shop) && in_array($_GET['online'],$online)){
if ($_GET['online'] =='yes'){
    $shop_list = Shop::ret_marketplace_shop_list($_GET['category']);
}else{
    $shop_list = Shop::ret_real_shop_list($_GET['category']);
}
}else{
    output_400_bad_request_error_page();
   exit;
}
$category = $_GET['category'];
$online = $_GET['online'];