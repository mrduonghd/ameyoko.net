<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');

//ログインチェック
admin_check();



	$event_no              = $_REQUEST['event_no'];
	

//削除処理

	if($event_no){

		$sql = "delete from t_event where event_no = '$event_no'";

		execsql($sql);
	
	}
	
//画像削除
	
	//画像保存先
	$img_dir = $_SERVER['DOCUMENT_ROOT'] . "/event/archive/" . $event_no;


	$image_count = "5";
	for($i=0;$i<$image_count;$i++){
		$n = $i + 1;
			$new_image_name[$i] = $img_dir . "/" .  $n . ".jpg";
			$thumb_image_name[$i] = $img_dir . "/t_" . $n . ".jpg";

		if(file_exists($new_image_name[$i])){
			unlink($new_image_name[$i]);
		}
		if(file_exists($thumb_image_name[$i])){
			unlink($thumb_image_name[$i]);
		}
	}
		system("rm -rf {$img_dir}");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>イベント情報作成完了</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
<a href="../logout.php">ログアウトする</a>  | <a href="../admin.php">メニューへ戻る</a>
</div>

<div id="stylized" class="myform">
  <h1>削除しました。</h1>
	<p><a href="./">イベント情報一覧へ戻る</a></p>
	<p><a href="../admin.php">メニューへ戻る</a></p>
</div>

</body>
</html>
