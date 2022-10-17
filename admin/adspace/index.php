<?php
session_start();

require_once('../../lib/Common_function.php');

//ログインチェック
login_check();


$shop_no = $_SESSION['shop_no'];
unset($_SESSION['Error']);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>広告一覧</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
ログイン店舗名：<strong><?php echo $_SESSION['shop_name'] ?></strong>　
<a href="../logout.php">ログアウトする</a>  | <a href="../">メニューへ戻る</a>
</div>

<div id="stylized" class="myform">
    <h1>広告一覧</h1>
    
     
		<?php
		/*-------------------------------------------------
		ステータス1
		-------------------------------------------------*/
		
		 $result = execsql("select * from t_topad_shop where shop_no = '$shop_no' and priority = '1' order by update DESC");
		 
		 ?>
         
		 <?php if($num = pg_num_rows($result)): ?>
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th bgcolor="#B6FEF3">登録日</th>
				<th bgcolor="#B6FEF3">タイトル</th>
				<th bgcolor="#B6FEF3">本文</th>
				<th width="50" bgcolor="#B6FEF3">状態</th>
				<th width="50" bgcolor="#B6FEF3">編集</th>
                <th width="50" bgcolor="#B6FEF3">削除</th>
		</tr>
			
			
		<?php
		 //契約数抽出
		 $count = pg_result($result,0,'count');
		 //記事抽出
		 $result = execsql("select * from t_topad where shop_no = '$shop_no' and priority = '1' order by update DESC");
		 
		 if($num = pg_num_rows($result)){
			
			for($i=0;$i<$num;$i++){
				//状態
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '掲載中';
				}else{
					$status[$i] = '非表示';
				}
				//編集用
				$topad_no = pg_result($result,$i,'topad_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./ad_maker.php">
				<input name="topad_no" type="hidden" value="$topad_no" />
				<input name="p" type="hidden" value="1" />
				<input name="submit" type="submit" value="編集する" />
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
				<input name="submit" type="submit" value="削除する" />
			  </form>
              </td>
		</tr>
       
 		<?php 
			}
			if($count > $num){
		?>
         <tr>
                <td colspan="5"><a href="ad_maker.php?p=1">広告を新規追加する(残り<?php echo $count - $num ?>枠 )</a></td>
        </tr>
		<?php
			}
		?>
        <?php
		}else{
		?>
		<tr>
                <td colspan="5"><a href="ad_maker.php?p=1">広告を新規追加する(残り<?php echo $count - $num ?>枠 )</a></td>
        </tr>
		<?php
		}
		?>
		</table>

		<?php endif;	?>
		
        <?php
        /*-------------------------------------------------
		ステータス1ここまで
		-------------------------------------------------*/
		?>

		<?php
		/*-------------------------------------------------
		ステータス2
		-------------------------------------------------*/
		
		 $result = execsql("select * from t_topad_shop where shop_no = '$shop_no' and priority = '2' order by update DESC");
		 
		 ?>
         
		 <?php if($num = pg_num_rows($result)): ?>
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th bgcolor="#B6FEF3">登録日</th>
				<th bgcolor="#B6FEF3">タイトル</th>
				<th bgcolor="#B6FEF3">本文</th>
				<th width="50" bgcolor="#B6FEF3">状態</th>
				<th width="50" bgcolor="#B6FEF3">編集</th>
                <th width="50" bgcolor="#B6FEF3">削除</th>
		</tr>
			
			
		<?php
		 //契約数抽出
		 $count = pg_result($result,0,'count');
		 //記事抽出
		 $result = execsql("select * from t_topad where shop_no = '$shop_no' and priority = '2' order by update DESC");
		 
		 if($num = pg_num_rows($result)){
			
			for($i=0;$i<$num;$i++){
				//状態
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '掲載中';
				}else{
					$status[$i] = '非表示';
				}
				//編集用
				$topad_no = pg_result($result,$i,'topad_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./ad_maker.php">
				<input name="topad_no" type="hidden" value="$topad_no" />
				<input name="p" type="hidden" value="2" />
				<input name="submit" type="submit" value="編集する" />
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
				<input name="submit" type="submit" value="削除する" />
			  </form>
              </td>
		</tr>
       
 		<?php 
			}
			if($count > $num){
		?>
         <tr>
                <td colspan="5"><a href="ad_maker.php?p=2">広告を新規追加する(残り<?php echo $count - $num ?>枠 )</a></td>
        </tr>
		<?php
			}
		?>
        <?php
		}else{
		?>
		<tr>
                <td colspan="5"><a href="ad_maker.php?p=2">広告を新規追加する(残り<?php echo $count - $num ?>枠 )</a></td>
        </tr>
		<?php
		}
		?>
		</table>

		<?php endif;	?>
		
        <?php
        /*-------------------------------------------------
		ステータス2ここまで
		-------------------------------------------------*/
		?>

		<?php
		/*-------------------------------------------------
		ステータス3
		-------------------------------------------------*/
		
		 $result = execsql("select * from t_topad_shop where shop_no = '$shop_no' and priority = '3' order by update DESC");
		 
		 ?>
         
		 <?php if($num = pg_num_rows($result)): ?>
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th bgcolor="#B6FEF3">登録日</th>
				<th bgcolor="#B6FEF3">タイトル</th>
				<th bgcolor="#B6FEF3">本文</th>
				<th width="50" bgcolor="#B6FEF3">状態</th>
				<th width="50" bgcolor="#B6FEF3">編集</th>
                <th width="50" bgcolor="#B6FEF3">削除</th>
		</tr>
			
			
		<?php
		 //契約数抽出
		 $count = pg_result($result,0,'count');
		 //記事抽出
		 $result = execsql("select * from t_topad where shop_no = '$shop_no' and priority = '3' order by update DESC");
		 
		 if($num = pg_num_rows($result)){
			
			for($i=0;$i<$num;$i++){
				//状態
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '掲載中';
				}else{
					$status[$i] = '非表示';
				}
				//編集用
				$topad_no = pg_result($result,$i,'topad_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./ad_maker.php">
				<input name="topad_no" type="hidden" value="$topad_no" />
				<input name="p" type="hidden" value="3" />
				<input name="submit" type="submit" value="編集する" />
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
				<input name="submit" type="submit" value="削除する" />
			  </form>
              </td>
		</tr>
       
 		<?php 
			}
			if($count > $num){
		?>
         <tr>
                <td colspan="5"><a href="ad_maker.php?p=3">広告を新規追加する(残り<?php echo $count - $num ?>枠 )</a></td>
        </tr>
		<?php
			}
		?>
        <?php
		}else{
		?>
		<tr>
                <td colspan="5"><a href="ad_maker.php?p=3">広告を新規追加する(残り<?php echo $count - $num ?>枠 )</a></td>
        </tr>
		<?php
		}
		?>
		</table>

		<?php endif;	?>
		
        <?php
        /*-------------------------------------------------
		ステータス3ここまで
		-------------------------------------------------*/
		?>
        
      


</div>

</body>
</html>
