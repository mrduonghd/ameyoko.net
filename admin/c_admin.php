<?php
session_start();

require_once('../lib/Common_function.php');

//����������å�
c_admin_check();


$where = Add_where("shop_no NOT IN('3','4','32','33','34','35','36','37','38','39','40','41','42','43')",$where);

$where = Add_where("shop_no between 318 and 423 ",$where);



$sql = "select shop_name,shop_id,shop_no,shop_passwd,status from m_shop ".$where." order by area_no";

$num = pg_num_rows($r = execsql($sql));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>����襳�ͥåȡ����ɥߥ˥��ȥ졼����������</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="header_logo">
<h1>����襳�ͥåȡ����ɥߥ˥��ȥ졼����������</h1>
</div>
<div id="login">
������̾��<strong><?php echo $_SESSION['c_admin_id'] ?></strong>(���󥿡��ӥ���)��
<a href="./logout.php">�������Ȥ���</a> 
</div>

<div id="stylized" class="myform">
<?php if($num): ?>
<p align="center"><a href="event/index.php">���٥�Ⱥ���</a></p>
<p align="center"><a href="topad/index.php">�ȥåץڡ��������ȷ������</a></p>
	<table border="0" cellpadding="5">
		<?php for($i=0;$i<$num;$i++){ ?>
		<tr>
			<td><?php echo pg_result($r,$i,'shop_no') ?></td>
			<td><?php echo pg_result($r,$i,'shop_name') ?>��</td>
			<td nowrap="nowrap"><?php echo pg_result($r,$i,'shop_id') ?></td>
			<td nowrap="nowrap"><?php echo pg_result($r,$i,'shop_passwd') ?></td>
			<td nowrap="nowrap"><?php if(pg_result($r,$i,'status') == 1){ echo '<font color="blue">ɽ����</font>'; }else{ echo '<font color="red">��ɽ��</font>'; }  ?></td>
			<td nowrap="nowrap"><a href="login.php?login_id=<?php echo pg_result($r,$i,'shop_id') ?>&passwd=<?php echo pg_result($r,$i,'shop_passwd') ?>&mode=Check" target="_blank">�����󤹤�</a></td>
		</tr>
		<?php } ?>
	</table>
<?php endif; ?>
</div>
</body>
</html>
