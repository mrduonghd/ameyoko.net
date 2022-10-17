<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../js/fckeditor/fckeditor.php');

//ログインチェック
login_check();

//登録
if($_REQUEST['mode'] == 'Reg'){

	$shop_no               = Input_format($_SESSION['shop_no']);
	$shop_name             = Input_format($_SESSION['shop_edit']['shop_name']);
	$shop_kana             = Input_format($_SESSION['shop_edit']['shop_kana']);
	$shop_name_e           = Input_format($_SESSION['shop_edit']['shop_name_e']);
	$shop_id               = Input_format($_SESSION['shop_edit']['shop_id']);
	$shop_passwd           = Input_format($_SESSION['shop_edit']['shop_passwd']);
	$m_shop_name           = Input_format($_SESSION['shop_edit']['m_shop_name']);
	$m_shop_name_e         = Input_format($_SESSION['shop_edit']['m_shop_name_e']);
	$category_no           = Input_format($_SESSION['shop_edit']['category_no']);
	$sub_category_no       = $_SESSION['shop_edit']['sub_category_no'];
	$map_no                = Input_format($_SESSION['shop_edit']['map_no']);
	$address               = Input_format_html($_SESSION['shop_edit']['address']);
	$address_e             = Input_format_html($_SESSION['shop_edit']['address_e']);
	$tel                   = Input_format($_SESSION['shop_edit']['tel']);
	$fax                   = Input_format($_SESSION['shop_edit']['fax']);
	$business_hours        = Input_format_html($_SESSION['shop_edit']['business_hours']);
	$regular_holiday       = Input_format_html($_SESSION['shop_edit']['regular_holiday']);
	$regular_holiday_e     = Input_format_html($_SESSION['shop_edit']['regular_holiday_e']);
	$select_line           = Input_format($_SESSION['shop_edit']['select_line']);
	$select_line_e         = Input_format($_SESSION['shop_edit']['select_line_e']);
	$sales                 = Input_format($_SESSION['shop_edit']['sales']);
	$payment               = Input_format($_SESSION['shop_edit']['payment']);
	$card                  = Input_format($_SESSION['shop_edit']['card']);
	$url                   = Input_format($_SESSION['shop_edit']['url']);
	$email                 = Input_format($_SESSION['shop_edit']['email']);
	$charge                = Input_format($_SESSION['shop_edit']['charge']);
	$charge_e              = Input_format($_SESSION['shop_edit']['charge_e']);
	$comment               = Input_format($_SESSION['shop_edit']['comment']);
	$comment_e             = Input_format($_SESSION['shop_edit']['comment_e']);
	$status                = Input_format($_SESSION['shop_edit']['status']);
	$tmp1               	 = Input_format($_SESSION['shop_edit']['keyword']);

	$update = date("Y-m-j H:i:s");

/*
	//入力値成型
	function Encode_Array($array,$pause){
		if(is_array($array)){
			for($i=0;$i < count($array);$i++){
				if($i){ $value .= $pause;}
				$value .= $array[$i];
			}
		}
		return $value;
	}

	if(is_array($sales)){ $sales = Encode_Array($sales,"::");}
	if(is_array($payment)){ $payment = Encode_Array($payment,"::");}
	if(is_array($card)){ $card = Encode_Array($card,"::");}

*/

	$sql = <<<EOF

update m_shop set

	shop_name            = '$shop_name',
	shop_kana            = '$shop_kana',
	shop_name_e          = '$shop_name_e',
	shop_id              = '$shop_id',
	shop_passwd          = '$shop_passwd',
	m_shop_name          = '$m_shop_name',
	m_shop_name_e        = '$m_shop_name_e',
	category_no          = '$category_no',
	map_no               = '$map_no',
	address              = '$address',
	address_e            = '$address_e',
	tel                  = '$tel',
	fax                  = '$fax',
	business_hours       = '$business_hours',
	regular_holiday      = '$regular_holiday',
	regular_holiday_e    = '$regular_holiday_e',
	select_line          = '$select_line',
	select_line_e        = '$select_line_e',
	sales                = '$sales',
	payment              = '$payment',
	card                 = '$card',
	url                  = '$url',
	email                = '$email',
	charge               = '$charge',
	charge_e             = '$charge_e',
	comment              = '$comment',
	comment_e            = '$comment_e',
	status               = '$status',
	tmp1                 = '$tmp1',
	update               = '$update'

where shop_no = '$shop_no'

EOF;

	execsql($sql);


	//statusが「2(非表示)」の時はトピックス＆クーポン＆求人テーブルのステータスを非表示に変更

	if($status == '2'){
		execsql("update t_topics set status = '2' where shop_no = '$shop_no'");
		execsql("update t_coupon set status = '2' where shop_no = '$shop_no'");
		execsql("update t_job_offer set status = '2' where shop_no = '$shop_no'");
		execsql("update t_item set status = '2' where shop_no = '$shop_no'");
	}

	//小カテゴリ更新

	execsql("delete from r_shop_category where shop_no = '$shop_no'");

	if(is_array($sub_category_no)){
		for($i=0;$i<sizeof($sub_category_no);$i++){
			execsql("insert into r_shop_category (category_no,shop_no) values ('$sub_category_no[$i]','$shop_no')");
		}
	}

	//画像移動

	//一時保存先
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];

	//画像保存先
	$img_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/shop_images/" . $_SESSION['shop_no'];
//	$img_dir = "../../shop/shop_images/" . $_SESSION['shop_no'];
	$thumb_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/shop_images/" . $_SESSION['shop_no'] . "/thumb";
//	$thumb_dir = "../../shop/shop_images/" . $_SESSION['shop_no'] . "/thumb";
	if(!is_dir($img_dir)) {
		mkdir($img_dir, 0777);
	}
	if(!is_dir($thumb_dir)) {
		mkdir($thumb_dir, 0777);
	}

	$image_count = "5";
	$flg = 0;
	for($i=0;$i<$image_count;$i++){
		$n = $i + 1;
		if(file_exists($tmp_dir . "/" . $i . ".jpg")){
			$tmp_image_name[$i] = $tmp_dir . "/" . $i . ".jpg";
			$new_image_name[$i] = $img_dir . "/" . $n . ".jpg";
			$thumb_image_name[$i] = $thumb_dir . "/" . $n . ".jpg";
		}
		//削除処理
		if($_SESSION['shop_edit']['image_del'][$i]){
			unlink($img_dir . "/" . $_SESSION['shop_edit']['image_del'][$i]);
			unlink($img_dir . "/thumb/" . $_SESSION['shop_edit']['image_del'][$i]);
		}

		if(file_exists($tmp_image_name[$i])){

			//画像リサイズ
			$length = "600";//長いほうのサイズ
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


			//サムネイル
//			if(file_exists($img_dir . "/thumb/1.jpg") or file_exists($img_dir . "/thumb/1.gif")){ $flg = 1; }
//			if(!$flg){
				if($i == 0){
				$length = "300";//長いほうのサイズ
//				$flg = 1;
			}else{
				$length = "120";//長いほうのサイズ
			}

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


}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>店舗情報編集</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
ログイン店舗名：<strong><?php echo $_SESSION['shop_name'] ?></strong>　
<a href="../logout.php">ログアウトする</a>  | <a href="../">メニューへ戻る</a>
</div>

<div id="stylized" class="myform">
  <h1>更新しました。</h1>
  <p><a href="../">メニューへ戻る</a></p>
</div>

</body>
</html>
