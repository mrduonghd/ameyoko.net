<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../js/fckeditor/fckeditor.php');

//ログインチェック
login_check();


//登録
if($_REQUEST['mode'] == 'Check'){

	$_SESSION['ad']['title']        = $_REQUEST['title'];
	$_SESSION['ad']['body']         = $_REQUEST['body'];
	$_SESSION['ad']['url']          = $_REQUEST['url'];
	$_SESSION['ad']['image_del']    = $_REQUEST['image_del'];
	$_SESSION['ad']['status']       = $_REQUEST['status'];

	//入力値チェック
	$InputCheck = new InputCheck();


	//	タイトル（NULL）
	if ($InputCheck->isEmpty($_SESSION['ad']['title'], 1, "＊タイトルを入力してください。")) {
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['ad']['title'],50,0, "タイトル")) { //桁数チェック
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
		$_SESSION['ad']['title'] = '';
	}else{
		$_SESSION['Error']['title'] = '';
	}

	//	本文（NULL）
	if ($InputCheck->isEmpty($_SESSION['ad']['body'], 1, "＊本文を入力してください。")) {
		$_SESSION['Error']['body'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['ad']['body'],100,0, "本文")) { //桁数チェック
		$_SESSION['Error']['body'] = ' style="background:#FFCC66"';
		$_SESSION['ad']['body'] = '';
	}else{
		$_SESSION['Error']['body'] = '';
	}
	
	if ($InputCheck->message) {
		$_SESSION['Error']['error_msg'] = $InputCheck->getMessage();
		header("Location: ./ad_maker.php?mode=Rewrite") ;
	}else{
	
	//画像関係
	//一時保存先
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];
	if(!is_dir($tmp_dir)) {
		mkdir($tmp_dir, 0777, true);
	}
	
	$image_count = "1";
	for($i=0;$i<$image_count;$i++){
		//既存の一時ファイルを削除
		if(file_exists($tmp_dir . "/" . $i .".jpg")){
			unlink($tmp_dir . "/" . $i . ".jpg");
		}
		
		if(preg_match("/jpeg/", $_FILES['t_images']["type"][$i])){
			$tmp_name[$i] = $tmp_dir . "/" . $i .".jpg";
			move_uploaded_file($_FILES['t_images']["tmp_name"][$i], $tmp_name[$i]);
		}
	}
		header("Location: ./ad_maker_exe.php?mode=Reg");
	}

}

//初期表示
if($shop_no = $_SESSION['shop_no'] and $_REQUEST['mode'] != 'Rewrite' and $_REQUEST['mode'] != 'Check'){
	
	$_SESSION['ad']['topad_no'] = $_REQUEST['topad_no'];
	
	if($topad_no = $_SESSION['ad']['topad_no']){
		$result = execsql("select * from t_topad where shop_no = '$shop_no' and topad_no = '$topad_no'");
		if(pg_num_rows($result)){
	
			$_SESSION['ad']['title']                 = pg_result($result,0,'title');
			$_SESSION['ad']['body']                  = pg_result($result,0,'body');
			$_SESSION['ad']['url']                   = pg_result($result,0,'url');
			$_SESSION['ad']['status']                = pg_result($result,0,'status');
	
		}else{
			unset($_SESSION['ad']);
		}
	}else{
        unset($_SESSION['ad']);

		//更新は一日一回
		$today = date("Y/m/d");
		$result = execsql("select topad_no from t_topad where shop_no = '$shop_no' and update >= '$today'");
		if(pg_num_rows($result)){
			//$today_flg = 1;
		}

	}

    unset($_SESSION['Error']);
	$_SESSION['ad']['p']        = $_REQUEST['p'];
	
	

}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>広告作成</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
ログイン店舗名：<strong><?php echo $_SESSION['shop_name'] ?></strong>　
<a href="../logout.php">ログアウトする</a>  | <a href="../">メニューへ戻る</a>
</div>
<div id="stylized" class="myform">

<?php if($today_flg): ?>

新規のおしらせは一日一回しか作成できません。<br />
当日作成したお知らせを変更してください。
	<p><a href="./">おしらせ一覧へ戻る</a></p>

<?php else: ?>

  <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <h1>広告作成</h1>
		<?php if($_SESSION['Error']['error_msg']): ?>
		<div class="caution">
		<?php echo $_SESSION['Error']['error_msg'] ?>
		</div>
		<?php endif; ?>

			<label>タイトル<span class="small">全角25文字以内 / <span style="color:#FF0000">*htmlタグ入力不可</span></span></label>
			<input name="title" type="text" id="title" value="<?php echo $_SESSION['ad']['title'] ?>"<?php echo $_SESSION['Error']['title'] ?> maxlength="25" />
     	<div class="spacer"></div>
						
			<label>お知らせ本文<span class="small">全角50文字以内 / <span style="color:#FF0000">*htmlタグ入力不可</span></span></label>
			
			<input name="body" type="text" id="body" value="<?php echo $_SESSION['ad']['body'] ?>"<?php echo $_SESSION['Error']['body'] ?> maxlength="50" />
     	<div class="spacer"></div>

			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<?php
			$image_count = 1;
			$img_dir ="../../ad_images/" . $_SESSION['shop_no'];
			for($i=0;$i<$image_count;$i++){
				$n = $i + 1;
			?>
			<p></p>
			<label>画像<?php echo $n ?><span class="small">自動的に適正サイズにリサイズされます<br />
    対応フォーマットは「jpg」です</span></label>
			<input type="file" size="32" name="t_images[]" value="" /><br />
			<?php if(file_exists($img_name = $img_dir . "/" . $topad_no . "_" . $n . ".jpg")): 	?>
			<div class="spacer"></div>
			
			<div align="center">現在登録されている画像:<input type="checkbox" name="image_del[]" id="image_del[]" value="<?php echo $topad_no . "_" . $n . ".jpg" ?>" />削除する場合はチェックしてください<br />
			<img src="<?php echo $img_name ?>" />
			</div>
			<?php endif; ?>
			
     	<div class="spacer"></div>

			<?php
			}
			?>

			<div align="center" style="font:bold; color:#F00">画像の容量は合計で2MB以内にしてください。<br />
登録ボタンを押したあと画面が真っ白になる場合は画像の容量がオーバーしている可能性があります。<br />
(サーバーの仕様上、エラーが出ません)</div>

			<p></p>

		<label>リンク先url<span class="small">未入力時は店舗紹介ページへリンクします</span></label>
			<input type="text" name="url" id="url" value="<?php echo $_SESSION['ad']['url'] ?>" />
     	<div class="spacer"></div>

		<label>掲載状態<span class="small">掲載を一時的にやめる場合は非表示にしてください</span></label>
			<input name="status" type="radio" id="status" value="1"<?php if($_SESSION['ad']['status'] == "1" or !$_SESSION['ad']['status']): ?>  checked="checked"<?php endif; ?> />
	    表示 | <input type="radio" name="status" id="status" value="2"<?php if($_SESSION['ad']['status'] == "2"): ?> checked="checked"<?php endif; ?> />非表示
    	<div class="spacer"></div>
			<br />
			<br />

		<input type="hidden" name="mode" id="mode" value="Check" />
		<button type="submit">登録する</button>
    <div class="spacer"></div>
  </form>

<?php endif; ?>

</div>

</body>
</html>
