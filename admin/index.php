<?php
session_cache_limiter('nocache');

session_start();

require_once('../lib/Common_function.php');

//ログインチェック
login_check();



$_SESSION['shop_edit'] = '';
$_SESSION['topics'] = '';
$_SESSION['coupon'] = '';
$_SESSION['job_offer'] = '';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>アメヨコネット　店舗管理画面</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="header_logo">
<h1>アメヨコネット　店舗管理画面</h1>
</div>
<div id="login">
ログイン店舗名：<strong><?php echo $_SESSION['shop_name']?></strong>　
<a href="./logout.php">ログアウトする</a> 
</div>


<div id="stylized" class="myform">
	<ul>
		<li id="menu_shop_edit"><a href="shop_edit/shop_edit.php">店舗情報編集</a></li>
	</ul>
</div>

</body>
</html>
