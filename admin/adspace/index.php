<?php
session_start();

require_once('../../lib/Common_function.php');

//����������å�
login_check();


$shop_no = $_SESSION['shop_no'];
unset($_SESSION['Error']);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>�������</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
������Ź��̾��<strong><?php echo $_SESSION['shop_name'] ?></strong>��
<a href="../logout.php">�������Ȥ���</a>  | <a href="../">��˥塼�����</a>
</div>

<div id="stylized" class="myform">
    <h1>�������</h1>
    
     
		<?php
		/*-------------------------------------------------
		���ơ�����1
		-------------------------------------------------*/
		
		 $result = execsql("select * from t_topad_shop where shop_no = '$shop_no' and priority = '1' order by update DESC");
		 
		 ?>
         
		 <?php if($num = pg_num_rows($result)): ?>
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th bgcolor="#B6FEF3">��Ͽ��</th>
				<th bgcolor="#B6FEF3">�����ȥ�</th>
				<th bgcolor="#B6FEF3">��ʸ</th>
				<th width="50" bgcolor="#B6FEF3">����</th>
				<th width="50" bgcolor="#B6FEF3">�Խ�</th>
                <th width="50" bgcolor="#B6FEF3">���</th>
		</tr>
			
			
		<?php
		 //��������
		 $count = pg_result($result,0,'count');
		 //�������
		 $result = execsql("select * from t_topad where shop_no = '$shop_no' and priority = '1' order by update DESC");
		 
		 if($num = pg_num_rows($result)){
			
			for($i=0;$i<$num;$i++){
				//����
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '�Ǻ���';
				}else{
					$status[$i] = '��ɽ��';
				}
				//�Խ���
				$topad_no = pg_result($result,$i,'topad_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./ad_maker.php">
				<input name="topad_no" type="hidden" value="$topad_no" />
				<input name="p" type="hidden" value="1" />
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
				<td><?php echo $edit[$i] ?></td>
                <td>
   			  <form id="form1" name="form1" method="get" action="./ad_maker_exe.php">
				<input name="topad_no" type="hidden" value="<?php echo $topad_no ?>" />
                <input name="mode" type="hidden" value="Del" />
				<input name="submit" type="submit" value="�������" />
			  </form>
              </td>
		</tr>
       
 		<?php 
			}
			if($count > $num){
		?>
         <tr>
                <td colspan="5"><a href="ad_maker.php?p=1">����򿷵��ɲä���(�Ĥ�<?php echo $count - $num ?>�� )</a></td>
        </tr>
		<?php
			}
		?>
        <?php
		}else{
		?>
		<tr>
                <td colspan="5"><a href="ad_maker.php?p=1">����򿷵��ɲä���(�Ĥ�<?php echo $count - $num ?>�� )</a></td>
        </tr>
		<?php
		}
		?>
		</table>

		<?php endif;	?>
		
        <?php
        /*-------------------------------------------------
		���ơ�����1�����ޤ�
		-------------------------------------------------*/
		?>

		<?php
		/*-------------------------------------------------
		���ơ�����2
		-------------------------------------------------*/
		
		 $result = execsql("select * from t_topad_shop where shop_no = '$shop_no' and priority = '2' order by update DESC");
		 
		 ?>
         
		 <?php if($num = pg_num_rows($result)): ?>
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th bgcolor="#B6FEF3">��Ͽ��</th>
				<th bgcolor="#B6FEF3">�����ȥ�</th>
				<th bgcolor="#B6FEF3">��ʸ</th>
				<th width="50" bgcolor="#B6FEF3">����</th>
				<th width="50" bgcolor="#B6FEF3">�Խ�</th>
                <th width="50" bgcolor="#B6FEF3">���</th>
		</tr>
			
			
		<?php
		 //��������
		 $count = pg_result($result,0,'count');
		 //�������
		 $result = execsql("select * from t_topad where shop_no = '$shop_no' and priority = '2' order by update DESC");
		 
		 if($num = pg_num_rows($result)){
			
			for($i=0;$i<$num;$i++){
				//����
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '�Ǻ���';
				}else{
					$status[$i] = '��ɽ��';
				}
				//�Խ���
				$topad_no = pg_result($result,$i,'topad_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./ad_maker.php">
				<input name="topad_no" type="hidden" value="$topad_no" />
				<input name="p" type="hidden" value="2" />
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
				<td><?php echo $edit[$i] ?></td>
                <td>
   			  <form id="form1" name="form1" method="get" action="./ad_maker_exe.php">
				<input name="topad_no" type="hidden" value="<?php echo $topad_no ?>" />
                <input name="mode" type="hidden" value="Del" />
				<input name="submit" type="submit" value="�������" />
			  </form>
              </td>
		</tr>
       
 		<?php 
			}
			if($count > $num){
		?>
         <tr>
                <td colspan="5"><a href="ad_maker.php?p=2">����򿷵��ɲä���(�Ĥ�<?php echo $count - $num ?>�� )</a></td>
        </tr>
		<?php
			}
		?>
        <?php
		}else{
		?>
		<tr>
                <td colspan="5"><a href="ad_maker.php?p=2">����򿷵��ɲä���(�Ĥ�<?php echo $count - $num ?>�� )</a></td>
        </tr>
		<?php
		}
		?>
		</table>

		<?php endif;	?>
		
        <?php
        /*-------------------------------------------------
		���ơ�����2�����ޤ�
		-------------------------------------------------*/
		?>

		<?php
		/*-------------------------------------------------
		���ơ�����3
		-------------------------------------------------*/
		
		 $result = execsql("select * from t_topad_shop where shop_no = '$shop_no' and priority = '3' order by update DESC");
		 
		 ?>
         
		 <?php if($num = pg_num_rows($result)): ?>
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th bgcolor="#B6FEF3">��Ͽ��</th>
				<th bgcolor="#B6FEF3">�����ȥ�</th>
				<th bgcolor="#B6FEF3">��ʸ</th>
				<th width="50" bgcolor="#B6FEF3">����</th>
				<th width="50" bgcolor="#B6FEF3">�Խ�</th>
                <th width="50" bgcolor="#B6FEF3">���</th>
		</tr>
			
			
		<?php
		 //��������
		 $count = pg_result($result,0,'count');
		 //�������
		 $result = execsql("select * from t_topad where shop_no = '$shop_no' and priority = '3' order by update DESC");
		 
		 if($num = pg_num_rows($result)){
			
			for($i=0;$i<$num;$i++){
				//����
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '�Ǻ���';
				}else{
					$status[$i] = '��ɽ��';
				}
				//�Խ���
				$topad_no = pg_result($result,$i,'topad_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./ad_maker.php">
				<input name="topad_no" type="hidden" value="$topad_no" />
				<input name="p" type="hidden" value="3" />
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
				<td><?php echo $edit[$i] ?></td>
                <td>
   			  <form id="form1" name="form1" method="get" action="./ad_maker_exe.php">
				<input name="topad_no" type="hidden" value="<?php echo $topad_no ?>" />
                <input name="mode" type="hidden" value="Del" />
				<input name="submit" type="submit" value="�������" />
			  </form>
              </td>
		</tr>
       
 		<?php 
			}
			if($count > $num){
		?>
         <tr>
                <td colspan="5"><a href="ad_maker.php?p=3">����򿷵��ɲä���(�Ĥ�<?php echo $count - $num ?>�� )</a></td>
        </tr>
		<?php
			}
		?>
        <?php
		}else{
		?>
		<tr>
                <td colspan="5"><a href="ad_maker.php?p=3">����򿷵��ɲä���(�Ĥ�<?php echo $count - $num ?>�� )</a></td>
        </tr>
		<?php
		}
		?>
		</table>

		<?php endif;	?>
		
        <?php
        /*-------------------------------------------------
		���ơ�����3�����ޤ�
		-------------------------------------------------*/
		?>
        
      


</div>

</body>
</html>
