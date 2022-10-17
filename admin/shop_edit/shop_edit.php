<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../../lib/C_category.php');
require_once('../js/fckeditor/fckeditor.php');
require_once('../../lib/checkbox.php');

//ログインチェック
login_check();

//登録
if($_REQUEST['mode'] == 'Check'){

	$_SESSION['shop_edit']['shop_name']                 = $_REQUEST['shop_name'];
	$_SESSION['shop_edit']['shop_kana']                 = $_REQUEST['shop_kana'];
	$_SESSION['shop_edit']['shop_name_e']               = $_REQUEST['shop_name_e'];
	$_SESSION['shop_edit']['shop_id']                   = $_REQUEST['shop_id'];
	$_SESSION['shop_edit']['shop_id_old']               = $_REQUEST['shop_id_old'];
	$_SESSION['shop_edit']['shop_passwd']               = $_REQUEST['shop_passwd'];
	$_SESSION['shop_edit']['m_shop_name']               = $_REQUEST['m_shop_name'];
	$_SESSION['shop_edit']['m_shop_name_e']             = $_REQUEST['m_shop_name_e'];
	$_SESSION['shop_edit']['category_no']               = $_REQUEST['category_no'];
	$_SESSION['shop_edit']['sub_category_no']           = $_REQUEST['sub_category_no'];
	$_SESSION['shop_edit']['map_no']                    = $_REQUEST['map_no'];
	$_SESSION['shop_edit']['address']                   = $_REQUEST['address'];
	$_SESSION['shop_edit']['address_e']                 = $_REQUEST['address_e'];
	$_SESSION['shop_edit']['tel']                       = $_REQUEST['tel'];
	$_SESSION['shop_edit']['fax']                       = $_REQUEST['fax'];
	$_SESSION['shop_edit']['business_hours']            = $_REQUEST['business_hours'];
	$_SESSION['shop_edit']['regular_holiday']           = $_REQUEST['regular_holiday'];
	$_SESSION['shop_edit']['regular_holiday_e']         = $_REQUEST['regular_holiday_e'] ;
	$_SESSION['shop_edit']['select_line']               = $_REQUEST['select_line'];
	$_SESSION['shop_edit']['select_line_e']             = $_REQUEST['select_line_e'];
	$_SESSION['shop_edit']['url']                       = $_REQUEST['url'];
	$_SESSION['shop_edit']['email']                     = $_REQUEST['email'];
	$_SESSION['shop_edit']['charge']                    = $_REQUEST['charge'];
	$_SESSION['shop_edit']['charge_e']                  = $_REQUEST['charge_e'];
	$_SESSION['shop_edit']['comment']                   = Input_format($_REQUEST['comment']);
	$_SESSION['shop_edit']['comment_e']                 = Input_format($_REQUEST['comment_e']);
	$_SESSION['shop_edit']['image_del']                 = $_REQUEST['image_del'];
	$_SESSION['shop_edit']['status']                    = $_REQUEST['status'];
	$_SESSION['shop_edit']['keyword']                   = $_REQUEST['keyword'];


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

	if(is_array($_REQUEST['sales'])){ $_SESSION['shop_edit']['sales'] = Encode_Array($_REQUEST['sales'],"::");}
	if(is_array($_REQUEST['payment'])){ $_SESSION['shop_edit']['payment'] = Encode_Array($_REQUEST['payment'],"::");}
	if(is_array($_REQUEST['card'])){ $_SESSION['shop_edit']['card'] = Encode_Array($_REQUEST['card'],"::");}


	//入力値チェック
	$InputCheck = new InputCheck();

	//	店舗名（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_name'], 1, "＊店舗名を入力してください。")) {
		$_SESSION['Error']['shop_name'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_name'] = '';
	}

	//	ふりがな（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_kana'], 1, "＊ふりがなを入力してください。")) {
		$_SESSION['Error']['shop_kana'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_kana'] = '';
	}

	//	店舗名（英語表記）（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_name_e'], 1, "＊店舗名（英語表記）を入力してください。")) {
		$_SESSION['Error']['shop_name_e'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_name_e'] = '';
	}

	//	ログインid（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_id'], 1, "＊ログインidを入力してください。")) {
		$_SESSION['Error']['shop_id'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['shop_edit']['shop_id'],20,4, "ログインid")) { //桁数チェック
		$_SESSION['Error']['shop_id'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_id'] = '';
	}

	//	ログインid重複
	if($_SESSION['shop_edit']['shop_id_old'] != $shop_id = $_SESSION['shop_edit']['shop_id']){
		if (pg_result(execsql("select count(0) from m_shop where shop_id = '$shop_id'"),0,count)){
			$InputCheck->isEmpty($sql_item_id, 1, "＊ログインidはすでに使用されております。");
			$_SESSION['Error']['shop_id'] = ' bgcolor="#F8C08D"';
		}elseif(pg_result(execsql("select count(0) from m_admin where admin_id = '$shop_id'"),0,count)){
			$InputCheck->isEmpty($sql_item_id, 1, "＊ログインidはすでに使用されております。");
			$_SESSION['Error']['shop_id'] = ' bgcolor="#F8C08D"';
		}else{
			$_SESSION['Error']['shop_id'] = '';
		}
	}

	//	パスワード（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_passwd'], 1, "＊パスワード入力してください。")) {
		$_SESSION['Error']['shop_passwd'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['shop_edit']['shop_passwd'],14,4, "ログインパスワード")) { //桁数チェック
		$_SESSION['Error']['shop_passwd'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_passwd'] = '';
	}

	//	簡略店舗名（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['m_shop_name'], 1, "＊簡略店舗名を入力してください。")) {
		$_SESSION['Error']['m_shop_name'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['m_shop_name'] = '';
	}

	//	簡略店舗名（英語表記）（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['m_shop_name_e'], 1, "＊簡略店舗名（英語表記）を入力してください。")) {
		$_SESSION['Error']['m_shop_name_e'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['m_shop_name_e'] = '';
	}

	//	住所（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['address'], 1, "＊住所を入力してください。")) {
		$_SESSION['Error']['address'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['address'] = '';
	}

	//	電話番号（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['tel'], 1, "＊電話番号を入力してください。")) {
		$_SESSION['Error']['tel'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['tel'] = '';
	}

	//	営業時間（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['business_hours'], 1, "＊営業時間を入力してください。")) {
		$_SESSION['Error']['business_hours'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['business_hours'] = '';
	}

	//	定休日（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['regular_holiday'], 1, "＊定休日を入力してください。")) {
		$_SESSION['Error']['regular_holiday'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['regular_holiday'] = '';
	}

	//	取扱商品（NULL）
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['select_line'], 1, "＊取扱商品を入力してください。")) {
		$_SESSION['Error']['select_line'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['select_line'] = '';
	}



	if ($InputCheck->message) {
		$_SESSION['Error']['error_msg'] = $InputCheck->getMessage();
		header("Location: ./shop_edit.php?mode=Rewrite") ;
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

		if(preg_match("/jpeg/", $_FILES['shop_images']["type"][$i])) {
			$tmp_name[$i] = $tmp_dir . "/" . $i .".jpg";
			move_uploaded_file($_FILES['shop_images']["tmp_name"][$i], $tmp_name[$i]);
		}
	}
		header("Location: ./shop_edit_exe.php?mode=Reg");
	}
}

//初期表示
if($shop_no = $_SESSION['shop_no'] and $_REQUEST['mode'] != 'Rewrite' and $_REQUEST['mode'] != 'Check'){

	if(pg_num_rows($result = execsql("select * from m_shop where shop_no = '$shop_no'"))){

        $_SESSION['shop_edit'] = array();
		$_SESSION['shop_edit']['shop_name']                 = pg_result($result,0,'shop_name');
		$_SESSION['shop_edit']['shop_kana']                 = pg_result($result,0,'shop_kana');
		$_SESSION['shop_edit']['shop_name_e']               = pg_result($result,0,'shop_name_e');
		$_SESSION['shop_edit']['shop_id']                   = pg_result($result,0,'shop_id');
		$_SESSION['shop_edit']['shop_id_old']               = pg_result($result,0,'shop_id');
		$_SESSION['shop_edit']['shop_passwd']               = pg_result($result,0,'shop_passwd');
		$_SESSION['shop_edit']['m_shop_name']               = pg_result($result,0,'m_shop_name');
		$_SESSION['shop_edit']['m_shop_name_e']             = pg_result($result,0,'m_shop_name_e');
		$_SESSION['shop_edit']['category_no']               = pg_result($result,0,'category_no');
		$_SESSION['shop_edit']['map_no']                    = pg_result($result,0,'map_no');
		$_SESSION['shop_edit']['address']                   = pg_result($result,0,'address');
		$_SESSION['shop_edit']['address_e']                 = pg_result($result,0,'address_e');
		$_SESSION['shop_edit']['tel']                       = pg_result($result,0,'tel');
		$_SESSION['shop_edit']['fax']                       = pg_result($result,0,'fax');
		$_SESSION['shop_edit']['business_hours']            = pg_result($result,0,'business_hours');
		$_SESSION['shop_edit']['regular_holiday']           = pg_result($result,0,'regular_holiday');
		$_SESSION['shop_edit']['regular_holiday_e']         = pg_result($result,0,'regular_holiday_e');
		$_SESSION['shop_edit']['select_line']               = pg_result($result,0,'select_line');
		$_SESSION['shop_edit']['select_line_e']             = pg_result($result,0,'select_line_e');
		$_SESSION['shop_edit']['sales']                     = pg_result($result,0,'sales');
		$_SESSION['shop_edit']['payment']                   = pg_result($result,0,'payment');
		$_SESSION['shop_edit']['card']                      = pg_result($result,0,'card');
		$_SESSION['shop_edit']['url']                       = pg_result($result,0,'url');
		$_SESSION['shop_edit']['email']                     = pg_result($result,0,'email');
		$_SESSION['shop_edit']['charge']                    = pg_result($result,0,'charge');
		$_SESSION['shop_edit']['charge_e']                  = pg_result($result,0,'charge_e');
		$_SESSION['shop_edit']['comment']                   = pg_result($result,0,'comment');
		$_SESSION['shop_edit']['comment_e']                 = pg_result($result,0,'comment_e');
		$_SESSION['shop_edit']['status']                    = pg_result($result,0,'status');
		$_SESSION['shop_edit']['keyword']                   = pg_result($result,0,'tmp1');

}

	if($num = pg_num_rows($result = execsql("select * from r_shop_category where shop_no = '$shop_no'"))){
		for($i=0;$i<$num;$i++){
            $_SESSION['shop_edit']['sub_category_no'][$i] = pg_result($result,$i,'category_no');
		}
	}

	unset($_SESSION['Error']);

}

//主要カテゴリを抽出
$Category = new Category();

if($_SESSION['shop_edit']['category_no']){
	$Category->get_Master_Category("where category_no = '".$_SESSION['shop_edit']['category_no']."'");
	$category_name = $Category->cCategory[0][category_name];
}
$Category->get_Master_Category("where category_type = '1'");

//追加カテゴリを抽出
$Category_sub = new Category();

if($_SESSION['shop_edit']['category_no']){
	$Category_sub->get_Master_Category("where category_no = '".$_SESSION['shop_edit']['category_no']."'");
	$category_name = $Category_sub->cCategory[0][category_name];
}
$Category_sub->get_Master_Category("where category_type = '2' order by category_no");


function list_view($array,$g_name,$form_name){
	$value = explode("::", $array);
	for($i = 0;$i < count($g_name);$i++){
		$check = "";
		for($n = 0;$n < count($value);$n++){
			if($value[$n] == $g_name[$i]){
				$check = ' checked=\"checked\"';
			}
		}
		$list .= "<input type=\"checkbox\" name=\"".$form_name."[]\" value=\"".$g_name[$i]."\"".$check." />".$g_name[$i]."\n";
	}
	return $list;
}

$sales_list = list_view($_SESSION['shop_edit']['sales'],CHECKBOX_SALE_NAME,"sales");
$payment_list = list_view($_SESSION['shop_edit']['payment'],CHECKBOX_PAYMENT_NAME,"payment");
$card_list = list_view($_SESSION['shop_edit']['card'],CHECKBOX_CARD_NAME,"card");

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
  <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <h1>店舗情報編集</h1>
		<?php if($_SESSION['Error']['error_msg']): ?>
		<div class="caution">
		<?php echo $_SESSION['Error']['error_msg'] ?>
		</div>
		<?php endif; ?>

    <fieldset>
			<legend>必須入力項目</legend>
			<p>下記項目はすべて入力してください。<span style="color:#FF0000">*htmlタグ入力不可</span></p>

			<label>アメヨコネット掲載状態<span class="small">表示/非表示</span></label>
			<?php
				if($_SESSION['shop_edit']['status'] == '1'){
					$c_1 = ' checked=checked';
				}else{
					$c_2 = ' checked=checked';
				}
			?>
			<div id=status>
			<input name="status" type="radio" id="status" value="1"<?php echo $c_1 ?> />表示　
     	<input name="status" type="radio" id="status" value="2"<?php echo $c_2 ?> />非表示
			</div>

			<div class="spacer"></div>

			<label>店舗名<span class="small">店舗詳細ページにて表示します</span></label>
			<input name="shop_name" type="text" id="shop_name" value="<?php echo $_SESSION['shop_edit']['shop_name'] ?>" />
     	<div class="spacer"></div>

			<label>ふりがな<span class="small">検索用</span></label>
			<input type="text" name="shop_kana" id="shop_kana" value="<?php echo $_SESSION['shop_edit']['shop_kana'] ?>" />
     	<div class="spacer"></div>

			<label>店舗名（英語表記）<span class="small">例)Ameyoko Syoukai Co. Ltd.</span></label>
			<input name="shop_name_e" type="text" id="shop_name_e" value="<?php echo $_SESSION['shop_edit']['shop_name_e'] ?>" />
     	<div class="spacer"></div>

			<label>ログイン用id <span class="small">6〜20文字の半角英数字にて入力してくだい</span></label>
			<input type="text" name="shop_id" id="shop_id" value="<?php echo $_SESSION['shop_edit']['shop_id'] ?>" />
			<input type="hidden" name="shop_id_old" id="shop_id" value="<?php echo $_SESSION['shop_edit']['shop_id_old'] ?>" />
     	<div class="spacer"></div>

			<label>ログイン用パスワード<span class="small">6〜14文字の半角英数字にて入力してくだい</span></label>
			<input type="text" name="shop_passwd" id="shop_passwd" value="<?php echo $_SESSION['shop_edit']['shop_passwd'] ?>" />
     	<div class="spacer"></div>

			<label>簡略店舗名<span class="small">地図表示用：全角10文字以内</span></label>
			<input type="text" name="m_shop_name" id="m_shop_name" value="<?php echo $_SESSION['shop_edit']['m_shop_name'] ?>" />
     	<div class="spacer"></div>

			<label>簡略店舗名（英語表記）<span class="small">半角10文字以内 例)Ameyoko Syoukai</span></label>
			<input type="text" name="m_shop_name_e" id="m_shop_name_e" value="<?php echo $_SESSION['shop_edit']['m_shop_name_e'] ?>" />

			<label>業種<span class="small">お店の主な業種を選択してください</span></label>
			<select name="category_no" id="category_no">
			<?php	if($_SESSION['shop_edit']['category_no']): ?>
				<option value="<?php echo $_SESSION['shop_edit']['category_no'] ?>" selected="selected"><?php echo $category_name ?></option>
	<option value="<?php echo $_SESSION['shop_edit']['category_no'] ?>">------------------</option>
				<?php if($Category->cCategory['count']): ?>
	<option value="<?php echo $Category->cCategory[0][category_no] ?>"><?php echo $Category->cCategory[0][category_name] ?></option>
				<?php endif; ?>
			<?php elseif($Category->cCategory['count']): ?>
	<option value="<?php echo $Category->cCategory[0][category_no] ?>" selected="selected"><?php echo $Category->cCategory[0][category_name] ?></option>
			<?php endif; ?>
			<?php
				if($Category->cCategory['count']){
					for($i=1;$i<$Category->cCategory['count'];$i++){
			?>
	<option value="<?php echo $Category->cCategory[$i][category_no] ?>"><?php echo $Category->cCategory[$i][category_name] ?></option>

			<?php
					}
				}
			?>
			</select>
     	<div class="spacer"></div>

			<label>住所<span class="small">エリア番号がある場合はそちらも入力してください</span></label>
			<input type="text" name="address" id="address" value="<?php echo $_SESSION['shop_edit']['address'] ?>" />
     	<div class="spacer"></div>

			<label>電話番号<span class="small">半角英数字及び-(ハイフン)にて入力してくだい</span></label>
			<input type="text" name="tel" id="tel" value="<?php echo $_SESSION['shop_edit']['tel'] ?>" />
     	<div class="spacer"></div>

			<label>営業時間<span class="small">例)am10:00-pm7:00</span></label>
			<input type="text" name="business_hours" id="business_hours" value="<?php echo $_SESSION['shop_edit']['business_hours'] ?>" />
     	<div class="spacer"></div>

			<label>定休日<span class="small">例)毎週木曜日及び第三水曜日</span></label>
			<input type="text" name="regular_holiday" id="regular_holiday" value="<?php echo $_SESSION['shop_edit']['regular_holiday'] ?>" />
     	<div class="spacer"></div>

			<label>取扱商品<span class="small">例)ルイヴィトン・資生堂・革製品全般・Ｔシャツ</span></label>
			<textarea name="select_line" rows="5" id="select_line"><?php echo $_SESSION['shop_edit']['select_line'] ?></textarea>
    	<div class="spacer"></div>

			<label>販売方法<span class="small">お取り扱いがある販売方法を選択してください</span></label>
<?php echo $sales_list ?>
    	<div class="spacer"></div>
			<br />
			<br />

			<label>決済方法<span class="small">お取り扱いがある決済方法を選択してください</span></label>
<?php echo $payment_list ?>
     	<div class="spacer"></div>
		</fieldset>

    <fieldset>
			<legend>オプション項目</legend>
			<p>下記項目は必要に応じて入力してください。<span style="color:#0000FF">*htmlタグ一部入力可</span></p>

			<label>地図番号<span class="small">アメ横ホームページマップ上の地図番号です。<br />
例)C1　</span></label>
			<input type="text" name="map_no" id="map_no" value="<?php echo $_SESSION['shop_edit']['map_no'] ?>" />
			<div class="spacer"></div>

			<label>取扱カード<span class="small">お取り扱いがあるカードを選択してください</span></label>
<?php echo $card_list ?>

    	<div class="spacer"></div>
			<br />
			<br />

			<label>追加業種<span class="small">取扱商品に関連がある業種をお選びください</span></label>

			<div id="area">
			<?php
				if($Category_sub->cCategory['count']){
					for($i=0;$i<$Category_sub->cCategory['count'];$i++){
						for($n=0;$n<sizeof($_SESSION['shop_edit']['sub_category_no']);$n++){
							if($_SESSION['shop_edit']['sub_category_no'][$n] == $Category_sub->cCategory[$i][category_no]){
								$sub_cate_checked[$i] = ' checked="checked"';
							}
						}
			?>

			<input name="sub_category_no[]" type="checkbox" id="sub_category_no" value="<?php echo $Category_sub->cCategory[$i][category_no] ?>"<?php echo $sub_cate_checked[$i] ?> />
			<?php echo $Category_sub->cCategory[$i][category_name] ?>

			<?php
					}
				}
			?>

			</div>
    	<div class="spacer"></div>
			<br />
			<br />

			<label>Fax番号<span class="small">半角英数字及び-(ハイフン)にて入力してくだい</span>
			</label>
			<input type="text" name="fax" id="fax" value="<?php echo $_SESSION['shop_edit']['fax'] ?>" />
     	<div class="spacer"></div>

			<label>ホームページurl<span class="small">例)http://www.ameyoko.net</span></label>
			<input type="text" name="url" id="url" value="<?php echo $_SESSION['shop_edit']['url'] ?>" />
     	<div class="spacer"></div>

			<label>メールアドレス<span class="small">例)info@ameyoko.net</span></label>
			<input type="text" name="email" id="email" value="<?php echo $_SESSION['shop_edit']['email'] ?>" />
     	<div class="spacer"></div>

			<label>販売責任者<span class="small">お客さまからのお問い合わせ受けられる方</span></label>
			<input type="text" name="charge" id="charge" value="<?php echo $_SESSION['shop_edit']['charge'] ?>" />
     	<div class="spacer"></div>

			<label>住所(英語表記)<span class="small">例)6-4-6,Ueno,Taitoh-ku,Tokyo</span></label>
			<input type="text" name="address_e" id="address_e" value="<?php echo $_SESSION['shop_edit']['address_e'] ?>" />
     	<div class="spacer"></div>

			<label>定休日(英語表記)<span class="small">例)Every Thursday &amp; the third Wednesday</span></label>
			<input type="text" name="regular_holiday_e" id="regular_holiday_e" value="<?php echo $_SESSION['regular_holiday_e'] ?>" />
     	<div class="spacer"></div>

			<label>販売責任者(英語表記)<span class="small">お客さまからのお問い合わせ受けられる方</span></label>
			<input type="text" name="charge_e" id="charge_e" value="<?php echo $_SESSION['shop_edit']['charge_e'] ?>" />
     	<div class="spacer"></div>

			<label>取扱商品(英語表記)<span class="small">例)louisvuitton・shiseido・leather goods</span></label>
			<textarea name="select_line_e" rows="5" id="select_line_e"><?php echo $_SESSION['shop_edit']['select_line_e'] ?></textarea>
     	<div class="spacer"></div>


			<label>お店紹介文<span class="small">htmlタグ利用可能です。</span></label>
			<?php
			$oFCKeditor = new FCKeditor('comment') ;
			$oFCKeditor->BasePath = '../js/fckeditor/';
			$oFCKeditor->Width = '300';
			$oFCKeditor->Height = '400';
			$oFCKeditor->ToolbarSet = 'Ameyoko_Basic';
			$oFCKeditor->Value = $_SESSION['shop_edit']['comment'];
			$oFCKeditor->Create() ;
			?>
    	<div class="spacer"></div>

			<label>お店紹介文(英語表記)<span class="small">htmlタグ利用可能です。</span></label>
			<?php
			$oFCKeditor = new FCKeditor('comment_e') ;
			$oFCKeditor->BasePath = '../js/fckeditor/';
			$oFCKeditor->Width = '300';
			$oFCKeditor->Height = '400';
			$oFCKeditor->ToolbarSet = 'Ameyoko_Basic';
			$oFCKeditor->Value = $_SESSION['shop_edit']['comment_e'];
			$oFCKeditor->Create() ;
			?>
     	<div class="spacer"></div>

			<p></p>
			<label>検索用キーワード<span class="small">スペースで区切って入力 例)ウーロン茶 烏龍茶</span></label>
			<input type="text" name="keyword" id="keyword" value="<?php echo $_SESSION['shop_edit']['keyword'] ?>" />
     	<div class="spacer"></div>

			<?php
			$image_count = 5;
			$img_dir ="../../shop/shop_images/" . $_SESSION['shop_no'];
			for($i=0;$i<$image_count;$i++){
				$n = $i + 1;
			?>
			<p></p>
			<label>画像<?php echo $n ?><span class="small">自動的に適正サイズにリサイズされます</span></label>
			<input type="file" size="32" name="shop_images[]" value="" /><br />
			<?php if(file_exists($img_name = $img_dir . "/" . $n . ".jpg")): 	?>
			<div class="spacer"></div>

			<div align="center">現在登録されている画像:<input type="checkbox" name="image_del[]" id="image_del[]" value="<?php echo $n . ".jpg" ?>" />削除する場合はチェックしてください<br />
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

		</fieldset>
 		<input type="hidden" name="mode" id="mode" value="Check" />
    <button type="submit">登録する</button>
  </form>
</div>

</body>
</html>
