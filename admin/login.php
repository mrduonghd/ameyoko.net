<?php
session_start();

require_once('../lib/Common_function.php');
require_once('../lib/C_check.php');

//id��passwd�����å�
if($_REQUEST['mode'] == 'Check'){

	$shop_id        = Input_format($_REQUEST['login_id']);
	$shop_passwd    = Input_format($_REQUEST['passwd']);
	
	if($shop_id and $shop_passwd){
		
		$shop = pg_num_rows($r = execsql("select shop_no from m_shop where shop_id = '$shop_id' and shop_passwd = '$shop_passwd'"));
		
		$admin = pg_result(execsql("select count(0) from m_admin where admin_id = '$shop_id' and admin_passwd = '$shop_passwd'"),0,count);

		$c_admin = pg_result(execsql("select count(0) from m_c_admin where c_admin_id = '$shop_id' and c_admin_passwd = '$shop_passwd'"),0,count);

		
		if($shop){
			$_SESSION['shop_id']     = $shop_id;
			$_SESSION['shop_passwd'] = $shop_passwd;
			$_SESSION['shop_no']     = pg_result($r,0,shop_no);
			header("Location: ./");
		}elseif($admin){
			$_SESSION['admin_id']     = $shop_id;
			$_SESSION['admin_passwd'] = $shop_passwd;
			header("Location: ./admin.php");
		}elseif($c_admin){
			$_SESSION['c_admin_id']     = $shop_id;
			$_SESSION['c_admin_passwd'] = $shop_passwd;
			header("Location: ./c_admin.php");
		}else{
			$InputCheck = new InputCheck();
			if($InputCheck->isEmpty("", 1, "����������󤬰㤤�ޤ�") ){
				$error = ' style="background:#FFCC66"';
			}
			if ($InputCheck->message) {
				$error_msg = $InputCheck->getMessage();
			}
		}
	}
}


//���ɽ��
if($_REQUEST['mode'] != 'Check'){
//	session_destroy();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>����襳�ͥåȡ�Ź�޴������̥�����</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="header_logo">
<h1>����襳�ͥåȡ�Ź�޴������̥�����</h1>
</div>
<div id="stylized" class="myform">
<?php if($error): ?>
<div style="color:#FF0000">
<?php echo $error_msg ?>
</div>
<?php endif; ?>
	<form name="login" method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">

		<label>��������id<span class="small">Ⱦ�Ѥˤ����Ϥ��Ƥ�������</span></label>
		<input name="login_id" type="text" id="login_id" value="<?php echo $shop_id ?>"<?php echo $error ?> />
		<div class="spacer"></div>
	
		<label>�ѥ����<span class="small">Ⱦ�Ѥˤ����Ϥ��Ƥ�������</span></label>
		<input name="passwd" type="password" id="passwd" value="<?php echo $shop_passwd ?>"<?php echo $error ?> />
		<div class="spacer"></div>
	
		<input type="hidden" name="mode" id="mode" value="Check" />
		<button type="submit">�����󤹤�</button>
    <div class="spacer"></div>

	</form>
</div>

</body>
</html>
