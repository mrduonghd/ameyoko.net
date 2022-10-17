<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');

//ログインチェック
admin_check();

//登録
if($_REQUEST['mode'] == 'Reg'){

	$event_no              = $_SESSION['event']['event_no'];
	
//	$title                 = Input_format($_SESSION['event']['title']);
	$title                 = $_SESSION['event']['title'];

	$title_e               = Input_format($_SESSION['event']['title_e']);
	$body                  = $_SESSION['event']['body'];
	$body_e                = $_SESSION['event']['body_e'];
	$status                = Input_format($_SESSION['event']['status']);

	$update = date("Y/m/j H:i:s");
	
	$i_name = $_SESSION['event']['images_name'];

	//更新処理の場合
	if($event_no){

		$sql = <<<EOF

update t_event set
	
	title                = '$title',
	title_e              = '$title_e',
	body                 = '$body',
	body_e               = '$body_e',
	status               = '$status'
	
where event_no = '$event_no'

EOF;

		execsql($sql);
	
	}else{

		$event_no = pg_result(execsql("select nextval('s_event_no')"),0,nextval);
	
		$sql = <<<EOF
	
insert into t_event(
	event_no,
	title,
	title_e,
	body,
	body_e,
	status,
	update
	)
	
values(
	'$event_no',
	'$title',
	'$title_e',
	'$body',
	'$body_e',
	'$status',
	'$update'
	)

EOF;

		execsql($sql);
	}
	
//画像移動
	
	//一時保存先
	$tmp_dir = "./tmp_dir";

	//画像保存先
	$img_dir = $_SERVER['DOCUMENT_ROOT'] . "/event/archive/" . $event_no;
//	$thumb_dir = $_SERVER['DOCUMENT_ROOT'] . "/event/archive/" . $event_no . "/thumb";

	if(!is_dir($img_dir)) {
		mkdir($img_dir, 0777);
	}
/*	if(!is_dir($thumb_dir)) {
		mkdir($thumb_dir, 0777);
	}
*/

	$image_count = "5";
	for($i=0;$i<$image_count;$i++){
		$n = $i + 1;
		if(file_exists($tmp_dir . "/" . $i . ".jpg")){
			$tmp_image_name[$i] = $tmp_dir . "/" . $i . ".jpg";
			$new_image_name[$i] = $img_dir . "/" .  $n . ".jpg";
			$thumb_image_name[$i] = $img_dir . "/t_" . $n . ".jpg";
		}
		//削除処理 
		if($_SESSION['event']['image_del'][$i]){
			unlink($img_dir . "/" .  $_SESSION['event']['image_del'][$i]);
			unlink($img_dir . "/t_" . $_SESSION['event']['image_del'][$i]);
		}

		if(file_exists($tmp_image_name[$i])){

			//画像リサイズ
			$length = "1200";//長いほうのサイズ
			list($o_width, $o_height) = getimagesize($tmp_image_name[$i]);
			if($o_width > $o_height){//横長
				$height = ($o_height / $o_width) * $length;
				$width = $length;
			}else{//縦長
				$width = ($o_width / $o_height) * $length;
				$height = $length;
			}
			$source = imagecreatefromjpeg($tmp_image_name[$i]);

			$new_image = imagecreatetruecolor($width,$height);
			imagecopyresampled($new_image,$source, 0, 0, 0, 0,$width, $height, $o_width, $o_height);
			ImageJPEG($new_image,$new_image_name[$i], 100);
			imagedestroy($new_image);

			unlink($tmp_image_name[$i]);
			chmod($new_image_name[$i],0666);
			
			
			//サムネイル
			$length = "300";//長いほうのサイズ
			
			list($o_width, $o_height) = getimagesize($new_image_name[$i]);
			if($o_width > $o_height){//横長
				$height = ($o_height / $o_width) * $length;
				$width = $length;
			}else{//縦長
				$width = ($o_width / $o_height) * $length;
				$height = $length;
			}
			$source = imagecreatefromjpeg($new_image_name[$i]);

			$thumb_image = imagecreatetruecolor($width,$height);
			imagecopyresampled($thumb_image,$source, 0, 0, 0, 0,$width, $height, $o_width, $o_height);
			ImageJPEG($thumb_image,$thumb_image_name[$i], 100);
			imagedestroy($thumb_image);

			chmod($new_image_name[$i],0666);

			
		}
	}
    unset($_SESSION['Error']);
    unset($_SESSION['Error']);

}else{

	header("Location: ../") ;

}


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
  <h1>更新しました。</h1>
	<p><a href="./">イベント情報一覧へ戻る</a></p>
	<p><a href="../admin.php">メニューへ戻る</a></p>
</div>

</body>
</html>
