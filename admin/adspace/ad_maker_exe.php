<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');

//ログインチェック
login_check();



//登録
if($_REQUEST['mode'] == 'Reg'){

	$shop_no               = $_SESSION['shop_no'];
	$topad_no              = $_SESSION['ad']['topad_no'];

	
	$title                 = Input_format($_SESSION['ad']['title']);
	$body                  = Input_format($_SESSION['ad']['body']);
	$url                   = $_SESSION['ad']['url'];
	$status                = Input_format($_SESSION['ad']['status']);
	$priority              = Input_format($_SESSION['ad']['p']);

	$update = date("Y/m/j H:i:s");
	
	$i_name = $_SESSION['ad']['images_name'];

	//更新処理の場合
	if($topad_no){

		$sql = <<<EOF

update t_topad set
	
	title                = '$title',
	body                 = '$body',
	url                  = '$url',
	priority             = '$priority',
	status               = '$status'
	
where shop_no = '$shop_no' and topad_no = '$topad_no'

EOF;

		execsql($sql);
	
	}else{
		
		//契約数チェック
		if(pg_num_rows($result = execsql("select * from t_topad_shop where shop_no = '".$shop_no . "' and priority = '". $priority. "'"))){
			$t_count = pg_result($result,0,'count');
		}
		//既存使用枠
		$ex_count = pg_num_rows($result = execsql("select * from t_topad where shop_no = '".$shop_no . "' and priority = '" .$priority. "'"));
		
		if($t_count > $ex_count){

			$topad_no = pg_result(execsql("select nextval('s_topad')"),0,nextval);
		
			$sql = <<<EOF
	
insert into t_topad(
	topad_no,
	shop_no,
	title,
	body,
	url,
	status,
	priority,
	update
	)
	
values(
	'$topad_no',
	'$shop_no',
	'$title',
	'$body',
	'$url',
	'$status',
	'$priority',
	'$update'
	)

EOF;

		execsql($sql);
		
		}else{
			$error = "契約数オーバーです";
			
			
		}
	}
	
	//画像移動
	
	//一時保存先
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];

	//画像保存先
	$img_dir = $_SERVER['DOCUMENT_ROOT'] . "/ad_images/" . $_SESSION['shop_no'];
	$thumb_dir = $_SERVER['DOCUMENT_ROOT'] . "/ad_images/" . $_SESSION['shop_no'] . "/thumb";
	
if(!is_dir($img_dir)) {
		mkdir($img_dir, 0777);
	}
if(!is_dir($thumb_dir)) {
		mkdir($thumb_dir, 0777);
	}

	$image_count = "1";
	for($i=0;$i<$image_count;$i++){
		$n = $i + 1;
		if(file_exists($tmp_dir . "/" . $i . ".jpg")){
			$tmp_image_name[$i] = $tmp_dir . "/" . $i . ".jpg";
			$new_image_name[$i] = $img_dir . "/" . $topad_no . "_" . $n . ".jpg";
			$thumb_image_name[$i] = $thumb_dir . "/" . $topad_no . "_" . $n . ".jpg";
		}
		//削除処理
		if($_SESSION['ad']['image_del'][$i]){
			unlink($img_dir . "/" . $_SESSION['ad']['image_del'][$i]);
			unlink($img_dir . "/thumb/" . $_SESSION['ad']['image_del'][$i]);
		}

		if(file_exists($tmp_image_name[$i])){

			//画像リサイズ
			$length = "260";//長いほうのサイズ
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
			

			$length = "192";//長いほうのサイズ
			
			
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
    unset($_SESSION['topics']);
}elseif($_REQUEST['mode'] == 'Del' and $topad_no = $_REQUEST['topad_no']){
	
	execsql("delete from t_topad where topad_no = '". $topad_no ."'");
		
}else{

	header("Location: ../") ;

}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>おしらせ作成完了</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
ログイン店舗名：<strong><?php echo $_SESSION['shop_name'] ?></strong>　
<a href="../logout.php">ログアウトする</a>  | <a href="../">メニューへ戻る</a>
</div>

<div id="stylized" class="myform">

  <?php if($error): ?>
  <h1><?php echo $error ?></h1>
  
  <?php else: ?>
  <h1>更新しました。</h1>
  <?php endif; ?>
	<p><a href="./">おしらせ一覧へ戻る</a></p>
	<p><a href="../">メニューへ戻る</a></p>
</div>

</body>
</html>
