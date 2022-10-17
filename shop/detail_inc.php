<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/shop/shop.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/Common_function.php");

if (isset($_GET['shop_no']) && $_GET['shop_no'] != '' && is_numeric($_GET['shop_no']) ==  true){

    $shop_data = Shop::ret_shop_data($_GET['shop_no']);
   if ($shop_data == false){
       output_404_not_found_error_page();
       exit;
   }
    $mp_shop_data = Shop::ret_marketplace_shop_data($_GET['shop_no']);

}else{
    output_400_bad_request_error_page();
    exit;
}
