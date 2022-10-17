<?php
session_start();

session_destroy();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<link href="./css/common.css" rel="stylesheet" type="text/css" />
<title>ログアウト</title>
</head>

<body>
<div id="stylized" class="myform">
	<p align="center">ログアウトしました。</p>
	<div align="center">
		<a href="login.php">ログイン画面へ</a>
	</div>
</div>
</body>
</html>
