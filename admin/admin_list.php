<?php
session_start();

require_once('../lib/Common_function.php');

//ログインチェック
admin_check();

$num = pg_num_rows($r = execsql("select shop_name,shop_id,shop_no,shop_passwd,status from m_shop where shop_name <> '' order by area_no"));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>アメヨコネット　アドミニストレータ管理画面</title>

</head>

<body>
<p><a href="event/index.php">イベント作成</a></p>

<?php if($num): ?>
<p>合計<?php echo $num ?>件</p>
	<table border="0" cellpadding="5" cellspacing="0">
		<?php for($i=0;$i<$num;$i++){ ?>
		<tr>
			<td><?php echo pg_result($r,$i,'shop_no') ?>　</td>
			<td><?php echo pg_result($r,$i,'shop_name') ?>　</td>
			<td nowrap="nowrap" style="font:24px large 'Palatino Linotype', 'Book Antiqua', Palatino, serif;"><?php echo pg_result($r,$i,'shop_id') ?>　</td>
			<td nowrap="nowrap" style="font:24px large 'Palatino Linotype', 'Book Antiqua', Palatino, serif;"><?php echo pg_result($r,$i,'shop_passwd') ?>　</td>
		</tr>
		<tr>
		<td colspan="4">&nbsp;</td>
		</tr>
		<?php } ?>
	</table>
<?php endif; ?>
</body>
</html>
