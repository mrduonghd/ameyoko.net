<?php
session_start();

require_once('../../lib/Common_function.php');

//����������å�
login_check();

//���ɽ��
if($shop_no = $_SESSION['shop_no']){

	$result = execsql("select * from t_topics where shop_no = '$shop_no' order by update DESC");
	if($num = pg_num_rows($result)){
	
			$_SESSION['topics']['topics_no']             = pg_result($result,0,'topics_no');
			$_SESSION['topics']['title']                 = pg_result($result,0,'title');
			$_SESSION['topics']['template']              = pg_result($result,0,'template');
			$_SESSION['topics']['body']                  = pg_result($result,0,'body');
			$_SESSION['topics']['status']                = pg_result($result,0,'status');
			$_SESSION['topics']['update']                = pg_result($result,0,'update');
	
	}

    unset($_SESSION['Error']);

}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>�����餻����</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
������Ź��̾��<strong><?php echo $_SESSION['shop_name'] ?></strong>��
<a href="../logout.php">�������Ȥ���</a>  | <a href="../">��˥塼�����</a>
</div>

<div id="stylized" class="myform">
    <h1>�����餻����</h1>
		<h2 align="center">
		<a href="topics_maker.php">�����������餻���������</a>
		</h2>
		<div class="caution">�ڽ��סۡ������������餻�����������ϡ�ľ��ε����Ȱ㤦���Ƥˤ��Ƥ���������</div>
		<hr />
		<?php if($num = pg_num_rows($result)): ?>
		�ǿ���20��ޤǤ�ɽ������ޤ���
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th width="150" bgcolor="#B6FEF3">��Ͽ��</th>
				<th bgcolor="#B6FEF3">�����ȥ�</th>
				<th bgcolor="#B6FEF3">��ʸ</th>
				<th width="50" bgcolor="#B6FEF3">����</th>
				<th width="50" bgcolor="#B6FEF3">�Խ�</th>
		</tr>
		<?php
			if($num > 20){ $num = 20; }
			for($i=0;$i<$num;$i++){
				//����
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '�Ǻ���';
				}else{
					$status[$i] = '��ɽ��';
				}
				//�Խ���
				$topics_no = pg_result($result,$i,'topics_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./topics_maker.php">
				<input name="topics_no" type="hidden" value="$topics_no" />
				<input name="submit" type="submit" value="�Խ�����" />
				</form>

				
EOF;
				
			$title = mb_substr(strip_tags(pg_result($result,$i,'title')), 0, 20);
			$body = mb_substr(strip_tags(pg_result($result,$i,'body')), 0, 20);
			
		?>
		<tr>
				<td width="150"><?php echo pg_result($result,$i,'update') ?>&nbsp;</td>
				<td><?php echo $title ?>&nbsp;</td>
				<td><?php echo $body ?>&nbsp;</td>
				<td><?php echo $status[$i] ?>&nbsp;</td>
				<td><?php echo $edit[$i] ?>&nbsp;</td>
		</tr>
		<?php 
			}
		?>
		</table>
		<?php else:	?>
		������Ͽ�Ϥ���ޤ���
		<?php endif;	?>

</div>

</body>
</html>
