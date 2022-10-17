<?php
session_start();

require_once('../../lib/Common_function.php');

//ログインチェック
admin_check();

//エラー初期化
unset($_SESSION['Error']);

//初期表示
$result = execsql("select * from t_event order by update DESC");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>イベント情報一覧</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
<a href="../logout.php">ログアウトする</a>  | <a href="../admin.php">メニューへ戻る</a>
</div>

<div id="stylized" class="myform">
    <h1>イベント情報一覧</h1>
		<h2 align="center">
		<a href="event_maker.php">新しいイベント情報を作成する</a>
		</h2>
		<hr />
		<?php if($num = pg_num_rows($result)): ?>
		最新の20件までが表示されます。
		<table width="100%" border="0" cellspacing="2" cellpadding="3">
		<tr>
				<th width="150" bgcolor="#B6FEF3">登録日</th>
				<th bgcolor="#B6FEF3">タイトル</th>
				<th bgcolor="#B6FEF3">本文</th>
				<th width="50" bgcolor="#B6FEF3">状態</th>
				<th width="50" bgcolor="#B6FEF3">編集</th>
				<th width="50" bgcolor="#B6FEF3">削除</th>
		</tr>
		<?php
			if($num > 20){ $num = 20; }
			for($i=0;$i<$num;$i++){
				//状態
				if(pg_result($result,$i,'status') == '1'){
					$status[$i] = '掲載中';
				}else{
					$status[$i] = '非表示';
				}
				//編集用
				$event_no = pg_result($result,$i,'event_no');
				
				$edit[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./event_maker.php">
				<input name="event_no" type="hidden" value="$event_no" />
				<input name="submit" type="submit" value="編集する" />
				</form>

EOF;

				$del[$i] = <<<EOF
				
			  <form id="form1" name="form1" method="get" action="./event_del_exe.php">
				<input name="event_no" type="hidden" value="$event_no" />
				<input name="submit" type="submit" value="削除する"  onclick='return confirm("本当に削除しますか");' />
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
				<td><?php echo $del[$i] ?>&nbsp;</td>
		</tr>
		<?php 
			}
		?>
		</table>
		<?php else:	?>
		現在登録はありません。
		<?php endif;	?>

</div>

</body>
</html>
