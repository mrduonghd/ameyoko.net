<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../js/fckeditor/fckeditor.php');

//ログインチェック
login_check();

//登録
if($_REQUEST['mode'] == 'Check'){

	$_SESSION['topics']['title']        = $_REQUEST['title'];
	$_SESSION['topics']['title_e']      = $_REQUEST['title_e'];
	$_SESSION['topics']['body']         = $_REQUEST['body'];
	$_SESSION['topics']['body_e']       = $_REQUEST['body_e'];
	$_SESSION['topics']['image_del']    = $_REQUEST['image_del'];
	$_SESSION['topics']['status']       = $_REQUEST['status'];
	$_SESSION['topics']['template']     = $_REQUEST['template'];

	//入力値チェック
	$InputCheck = new InputCheck();


	//	タイトル（NULL）
	if ($InputCheck->isEmpty($_SESSION['topics']['title'], 1, "＊タイトルを入力してください。")) {
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['topics']['title'],70,0, "タイトル")) { //桁数チェック
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['title'] = '';
	}

	//	本文（NULL）
	if ($InputCheck->isEmpty($_SESSION['topics']['body'], 1, "＊おしらせ本文を入力してください。")) {
		$_SESSION['Error']['body'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['body'] = '';
	}
	
	if ($InputCheck->message) {
		$_SESSION['Error']['error_msg'] = $InputCheck->getMessage();
		header("Location: ./topics_maker.php?mode=Rewrite") ;
	}else{
	
	//画像関係
	//一時保存先
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];
	if(!is_dir($tmp_dir)) {
		mkdir($tmp_dir, 0777, true);
	}
	
	$image_count = "5";
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
		header("Location: ./topics_maker_exe.php?mode=Reg");
	}

}

//初期表示
if($shop_no = $_SESSION['shop_no'] and $_REQUEST['mode'] != 'Rewrite' and $_REQUEST['mode'] != 'Check'){

    $_SESSION['topics'] = array();
	$_SESSION['topics']['topics_no'] = $_REQUEST['topics_no'];

	if($topics_no = $_SESSION['topics']['topics_no']){
		$result = execsql("select * from t_topics where shop_no = '$shop_no' and topics_no = '$topics_no'");
		if(pg_num_rows($result)){
	
			$_SESSION['topics']['title']                 = pg_result($result,0,'title');
			$_SESSION['topics']['title_e']               = pg_result($result,0,'title_e');
			$_SESSION['topics']['template']              = pg_result($result,0,'template');
			$_SESSION['topics']['body']                  = pg_result($result,0,'body');
			$_SESSION['topics']['body_e']                = pg_result($result,0,'body_e');
			$_SESSION['topics']['status']                = pg_result($result,0,'status');
	
		}else{

            unset($_SESSION['topics']);
		}

	}else{

        unset($_SESSION['topics']);

		//更新は一日一回
		$today = date("Y/m/d");
		$result = execsql("select topics_no from t_topics where shop_no = '$shop_no' and update >= '$today'");
		if(pg_num_rows($result)){
			$today_flg = 1;
		}

	}

    unset($_SESSION['Error']);

}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>おしらせ作成</title>
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
    <h1>おしらせ作成</h1>
		<?php if($_SESSION['Error']['error_msg']): ?>
		<div class="caution">
		<?php echo $_SESSION['Error']['error_msg'] ?>
		</div>
		<?php endif; ?>
			<label>表示位置<span class="small">ページ上部が下部を選択できます</span></span></label>
			<input type="radio" name="template" id="template" value="1"<?php if($_SESSION['topics']['template'] == "1" or !$_SESSION['topics']['template']): ?>  checked="checked"<?php endif; ?> />上部
			<input type="radio" name="template" id="template" value="2"<?php if($_SESSION['topics']['template'] == "2"): ?> checked="checked"<?php endif; ?> />下部
     	<div class="spacer"></div>

			<label>タイトル<span class="small">全角35文字以内 / <span style="color:#FF0000">*htmlタグ入力不可</span></span></label>
			<input name="title" type="text" id="title" value="<?php echo $_SESSION['topics']['title'] ?>"<?php echo $_SESSION['Error']['title'] ?> />
     	<div class="spacer"></div>
			
			<label>タイトル(英語表記)<span class="small">半角35文字以内 / <span style="color:#FF0000">*htmlタグ入力不可</span></span></label>
			<input type="text" name="title_e" id="title_e" value="<?php echo $_SESSION['topics']['title_e'] ?>" />
     	<div class="spacer"></div>
			
			<label>お知らせ本文<span class="small">htmlタグ利用可能です。</span></label>
			<?php
			$oFCKeditor = new FCKeditor('body') ;
			$oFCKeditor->BasePath = '../js/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '400';
			$oFCKeditor->ToolbarSet = 'Ameyoko';
			$oFCKeditor->Value = $_SESSION['topics']['body'];
			$oFCKeditor->Create() ;
			?>
     	<div class="spacer"></div>

 			<label>お知らせ本文(英語表記)<span class="small">htmlタグ利用可能です。</span></label>
			<?php
			$oFCKeditor = new FCKeditor('body_e') ;
			$oFCKeditor->BasePath = '../js/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '400';
			$oFCKeditor->ToolbarSet = 'Ameyoko';
			$oFCKeditor->Value = $_SESSION['topics']['body_e'];
			$oFCKeditor->Create() ;
			?>
    	<div class="spacer"></div>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<?php
			$image_count = 5;
			$img_dir ="../../shop/t_images/" . $_SESSION['shop_no'];
			for($i=0;$i<$image_count;$i++){
				$n = $i + 1;
			?>
			<p></p>
			<label>画像<?php echo $n ?><span class="small">自動的に適正サイズにリサイズされます</span></label>
			<input type="file" size="32" name="t_images[]" value="" /><br />
			<?php if(file_exists($img_name = $img_dir . "/" . $topics_no . "_" . $n . ".jpg")): 	?>
			<div class="spacer"></div>
			
			<div align="center">現在登録されている画像:<input type="checkbox" name="image_del[]" id="image_del[]" value="<?php echo $topics_no . "_" . $n . ".jpg" ?>" />削除する場合はチェックしてください<br />
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

			<label>掲載状態<span class="small">掲載を一時的にやめる場合は非表示にしてください</span></label>
			<input name="status" type="radio" id="status" value="1"<?php if($_SESSION['topics']['status'] == "1" or !$_SESSION['topics']['status']): ?>  checked="checked"<?php endif; ?> />
	    表示 | <input type="radio" name="status" id="status" value="2"<?php if($_SESSION['topics']['status'] == "2"): ?> checked="checked"<?php endif; ?> />非表示
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
