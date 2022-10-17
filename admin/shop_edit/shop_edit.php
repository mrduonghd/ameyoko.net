<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../../lib/C_category.php');
require_once('../js/fckeditor/fckeditor.php');
require_once('../../lib/checkbox.php');

//����������å�
login_check();

//��Ͽ
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


	//����������
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


	//�����ͥ����å�
	$InputCheck = new InputCheck();

	//	Ź��̾��NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_name'], 1, "��Ź��̾�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['shop_name'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_name'] = '';
	}

	//	�դ꤬�ʡ�NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_kana'], 1, "���դ꤬�ʤ����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['shop_kana'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_kana'] = '';
	}

	//	Ź��̾�ʱѸ�ɽ���ˡ�NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_name_e'], 1, "��Ź��̾�ʱѸ�ɽ���ˤ����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['shop_name_e'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_name_e'] = '';
	}

	//	������id��NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_id'], 1, "��������id�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['shop_id'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['shop_edit']['shop_id'],20,4, "������id")) { //��������å�
		$_SESSION['Error']['shop_id'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_id'] = '';
	}

	//	������id��ʣ
	if($_SESSION['shop_edit']['shop_id_old'] != $shop_id = $_SESSION['shop_edit']['shop_id']){
		if (pg_result(execsql("select count(0) from m_shop where shop_id = '$shop_id'"),0,count)){
			$InputCheck->isEmpty($sql_item_id, 1, "��������id�Ϥ��Ǥ˻��Ѥ���Ƥ���ޤ���");
			$_SESSION['Error']['shop_id'] = ' bgcolor="#F8C08D"';
		}elseif(pg_result(execsql("select count(0) from m_admin where admin_id = '$shop_id'"),0,count)){
			$InputCheck->isEmpty($sql_item_id, 1, "��������id�Ϥ��Ǥ˻��Ѥ���Ƥ���ޤ���");
			$_SESSION['Error']['shop_id'] = ' bgcolor="#F8C08D"';
		}else{
			$_SESSION['Error']['shop_id'] = '';
		}
	}

	//	�ѥ���ɡ�NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['shop_passwd'], 1, "���ѥ�������Ϥ��Ƥ���������")) {
		$_SESSION['Error']['shop_passwd'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['shop_edit']['shop_passwd'],14,4, "������ѥ����")) { //��������å�
		$_SESSION['Error']['shop_passwd'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['shop_passwd'] = '';
	}

	//	��άŹ��̾��NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['m_shop_name'], 1, "����άŹ��̾�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['m_shop_name'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['m_shop_name'] = '';
	}

	//	��άŹ��̾�ʱѸ�ɽ���ˡ�NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['m_shop_name_e'], 1, "����άŹ��̾�ʱѸ�ɽ���ˤ����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['m_shop_name_e'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['m_shop_name_e'] = '';
	}

	//	�����NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['address'], 1, "����������Ϥ��Ƥ���������")) {
		$_SESSION['Error']['address'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['address'] = '';
	}

	//	�����ֹ��NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['tel'], 1, "�������ֹ�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['tel'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['tel'] = '';
	}

	//	�ĶȻ��֡�NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['business_hours'], 1, "���ĶȻ��֤����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['business_hours'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['business_hours'] = '';
	}

	//	�������NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['regular_holiday'], 1, "������������Ϥ��Ƥ���������")) {
		$_SESSION['Error']['regular_holiday'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['regular_holiday'] = '';
	}

	//	�谷���ʡ�NULL��
	if ($InputCheck->isEmpty($_SESSION['shop_edit']['select_line'], 1, "���谷���ʤ����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['select_line'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['select_line'] = '';
	}



	if ($InputCheck->message) {
		$_SESSION['Error']['error_msg'] = $InputCheck->getMessage();
		header("Location: ./shop_edit.php?mode=Rewrite") ;
	}else{

	//�����ط�
	//�����¸��
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];
	if(!is_dir($tmp_dir)) {
		mkdir($tmp_dir, 0777, true);
	}

	$image_count = "5";
	for($i=0;$i<$image_count;$i++){

		//��¸�ΰ���ե��������
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

//���ɽ��
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

//���ץ��ƥ�������
$Category = new Category();

if($_SESSION['shop_edit']['category_no']){
	$Category->get_Master_Category("where category_no = '".$_SESSION['shop_edit']['category_no']."'");
	$category_name = $Category->cCategory[0][category_name];
}
$Category->get_Master_Category("where category_type = '1'");

//�ɲå��ƥ�������
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
<title>Ź�޾����Խ�</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
������Ź��̾��<strong><?php echo $_SESSION['shop_name'] ?></strong>��
<a href="../logout.php">�������Ȥ���</a>  | <a href="../">��˥塼�����</a>
</div>

<div id="stylized" class="myform">
  <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <h1>Ź�޾����Խ�</h1>
		<?php if($_SESSION['Error']['error_msg']): ?>
		<div class="caution">
		<?php echo $_SESSION['Error']['error_msg'] ?>
		</div>
		<?php endif; ?>

    <fieldset>
			<legend>ɬ�����Ϲ���</legend>
			<p>�������ܤϤ��٤����Ϥ��Ƥ���������<span style="color:#FF0000">*html���������Բ�</span></p>

			<label>����襳�ͥåȷǺܾ���<span class="small">ɽ��/��ɽ��</span></label>
			<?php
				if($_SESSION['shop_edit']['status'] == '1'){
					$c_1 = ' checked=checked';
				}else{
					$c_2 = ' checked=checked';
				}
			?>
			<div id=status>
			<input name="status" type="radio" id="status" value="1"<?php echo $c_1 ?> />ɽ����
     	<input name="status" type="radio" id="status" value="2"<?php echo $c_2 ?> />��ɽ��
			</div>

			<div class="spacer"></div>

			<label>Ź��̾<span class="small">Ź�޾ܺ٥ڡ����ˤ�ɽ�����ޤ�</span></label>
			<input name="shop_name" type="text" id="shop_name" value="<?php echo $_SESSION['shop_edit']['shop_name'] ?>" />
     	<div class="spacer"></div>

			<label>�դ꤬��<span class="small">������</span></label>
			<input type="text" name="shop_kana" id="shop_kana" value="<?php echo $_SESSION['shop_edit']['shop_kana'] ?>" />
     	<div class="spacer"></div>

			<label>Ź��̾�ʱѸ�ɽ����<span class="small">��)Ameyoko Syoukai Co. Ltd.</span></label>
			<input name="shop_name_e" type="text" id="shop_name_e" value="<?php echo $_SESSION['shop_edit']['shop_name_e'] ?>" />
     	<div class="spacer"></div>

			<label>��������id <span class="small">6��20ʸ����Ⱦ�ѱѿ����ˤ����Ϥ��Ƥ�����</span></label>
			<input type="text" name="shop_id" id="shop_id" value="<?php echo $_SESSION['shop_edit']['shop_id'] ?>" />
			<input type="hidden" name="shop_id_old" id="shop_id" value="<?php echo $_SESSION['shop_edit']['shop_id_old'] ?>" />
     	<div class="spacer"></div>

			<label>�������ѥѥ����<span class="small">6��14ʸ����Ⱦ�ѱѿ����ˤ����Ϥ��Ƥ�����</span></label>
			<input type="text" name="shop_passwd" id="shop_passwd" value="<?php echo $_SESSION['shop_edit']['shop_passwd'] ?>" />
     	<div class="spacer"></div>

			<label>��άŹ��̾<span class="small">�Ͽ�ɽ���ѡ�����10ʸ������</span></label>
			<input type="text" name="m_shop_name" id="m_shop_name" value="<?php echo $_SESSION['shop_edit']['m_shop_name'] ?>" />
     	<div class="spacer"></div>

			<label>��άŹ��̾�ʱѸ�ɽ����<span class="small">Ⱦ��10ʸ������ ��)Ameyoko Syoukai</span></label>
			<input type="text" name="m_shop_name_e" id="m_shop_name_e" value="<?php echo $_SESSION['shop_edit']['m_shop_name_e'] ?>" />

			<label>�ȼ�<span class="small">��Ź�μ�ʶȼ�����򤷤Ƥ�������</span></label>
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

			<label>����<span class="small">���ꥢ�ֹ椬������Ϥ���������Ϥ��Ƥ�������</span></label>
			<input type="text" name="address" id="address" value="<?php echo $_SESSION['shop_edit']['address'] ?>" />
     	<div class="spacer"></div>

			<label>�����ֹ�<span class="small">Ⱦ�ѱѿ����ڤ�-(�ϥ��ե�)�ˤ����Ϥ��Ƥ�����</span></label>
			<input type="text" name="tel" id="tel" value="<?php echo $_SESSION['shop_edit']['tel'] ?>" />
     	<div class="spacer"></div>

			<label>�ĶȻ���<span class="small">��)am10:00-pm7:00</span></label>
			<input type="text" name="business_hours" id="business_hours" value="<?php echo $_SESSION['shop_edit']['business_hours'] ?>" />
     	<div class="spacer"></div>

			<label>�����<span class="small">��)�轵�������ڤ��軰������</span></label>
			<input type="text" name="regular_holiday" id="regular_holiday" value="<?php echo $_SESSION['shop_edit']['regular_holiday'] ?>" />
     	<div class="spacer"></div>

			<label>�谷����<span class="small">��)�륤�����ȥ󡦻���Ʋ�����������̡��ԥ����</span></label>
			<textarea name="select_line" rows="5" id="select_line"><?php echo $_SESSION['shop_edit']['select_line'] ?></textarea>
    	<div class="spacer"></div>

			<label>������ˡ<span class="small">����갷��������������ˡ�����򤷤Ƥ�������</span></label>
<?php echo $sales_list ?>
    	<div class="spacer"></div>
			<br />
			<br />

			<label>�����ˡ<span class="small">����갷������������ˡ�����򤷤Ƥ�������</span></label>
<?php echo $payment_list ?>
     	<div class="spacer"></div>
		</fieldset>

    <fieldset>
			<legend>���ץ�������</legend>
			<p>�������ܤ�ɬ�פ˱��������Ϥ��Ƥ���������<span style="color:#0000FF">*html�����������ϲ�</span></p>

			<label>�Ͽ��ֹ�<span class="small">���Უ�ۡ���ڡ����ޥå׾���Ͽ��ֹ�Ǥ���<br />
��)C1��</span></label>
			<input type="text" name="map_no" id="map_no" value="<?php echo $_SESSION['shop_edit']['map_no'] ?>" />
			<div class="spacer"></div>

			<label>�谷������<span class="small">����갷�������륫���ɤ����򤷤Ƥ�������</span></label>
<?php echo $card_list ?>

    	<div class="spacer"></div>
			<br />
			<br />

			<label>�ɲöȼ�<span class="small">�谷���ʤ˴�Ϣ������ȼ�����Ӥ�������</span></label>

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

			<label>Fax�ֹ�<span class="small">Ⱦ�ѱѿ����ڤ�-(�ϥ��ե�)�ˤ����Ϥ��Ƥ�����</span>
			</label>
			<input type="text" name="fax" id="fax" value="<?php echo $_SESSION['shop_edit']['fax'] ?>" />
     	<div class="spacer"></div>

			<label>�ۡ���ڡ���url<span class="small">��)http://www.ameyoko.net</span></label>
			<input type="text" name="url" id="url" value="<?php echo $_SESSION['shop_edit']['url'] ?>" />
     	<div class="spacer"></div>

			<label>�᡼�륢�ɥ쥹<span class="small">��)info@ameyoko.net</span></label>
			<input type="text" name="email" id="email" value="<?php echo $_SESSION['shop_edit']['email'] ?>" />
     	<div class="spacer"></div>

			<label>������Ǥ��<span class="small">���Ҥ��ޤ���Τ��䤤��碌����������</span></label>
			<input type="text" name="charge" id="charge" value="<?php echo $_SESSION['shop_edit']['charge'] ?>" />
     	<div class="spacer"></div>

			<label>����(�Ѹ�ɽ��)<span class="small">��)6-4-6,Ueno,Taitoh-ku,Tokyo</span></label>
			<input type="text" name="address_e" id="address_e" value="<?php echo $_SESSION['shop_edit']['address_e'] ?>" />
     	<div class="spacer"></div>

			<label>�����(�Ѹ�ɽ��)<span class="small">��)Every Thursday &amp; the third Wednesday</span></label>
			<input type="text" name="regular_holiday_e" id="regular_holiday_e" value="<?php echo $_SESSION['regular_holiday_e'] ?>" />
     	<div class="spacer"></div>

			<label>������Ǥ��(�Ѹ�ɽ��)<span class="small">���Ҥ��ޤ���Τ��䤤��碌����������</span></label>
			<input type="text" name="charge_e" id="charge_e" value="<?php echo $_SESSION['shop_edit']['charge_e'] ?>" />
     	<div class="spacer"></div>

			<label>�谷����(�Ѹ�ɽ��)<span class="small">��)louisvuitton��shiseido��leather goods</span></label>
			<textarea name="select_line_e" rows="5" id="select_line_e"><?php echo $_SESSION['shop_edit']['select_line_e'] ?></textarea>
     	<div class="spacer"></div>


			<label>��Ź�Ҳ�ʸ<span class="small">html�������Ѳ�ǽ�Ǥ���</span></label>
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

			<label>��Ź�Ҳ�ʸ(�Ѹ�ɽ��)<span class="small">html�������Ѳ�ǽ�Ǥ���</span></label>
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
			<label>�����ѥ������<span class="small">���ڡ����Ƕ��ڤä����� ��)��������� ��ζ��</span></label>
			<input type="text" name="keyword" id="keyword" value="<?php echo $_SESSION['shop_edit']['keyword'] ?>" />
     	<div class="spacer"></div>

			<?php
			$image_count = 5;
			$img_dir ="../../shop/shop_images/" . $_SESSION['shop_no'];
			for($i=0;$i<$image_count;$i++){
				$n = $i + 1;
			?>
			<p></p>
			<label>����<?php echo $n ?><span class="small">��ưŪ��Ŭ���������˥ꥵ��������ޤ�</span></label>
			<input type="file" size="32" name="shop_images[]" value="" /><br />
			<?php if(file_exists($img_name = $img_dir . "/" . $n . ".jpg")): 	?>
			<div class="spacer"></div>

			<div align="center">������Ͽ����Ƥ������:<input type="checkbox" name="image_del[]" id="image_del[]" value="<?php echo $n . ".jpg" ?>" />���������ϥ����å����Ƥ�������<br />
			<img src="<?php echo $img_name ?>" />
			</div>
			<?php endif; ?>

     	<div class="spacer"></div>

			<?php
			}
			?>
			<div align="center" style="font:bold; color:#F00">���������̤Ϲ�פ�2MB����ˤ��Ƥ���������<br />
��Ͽ�ܥ���򲡤������Ȳ��̤�������ˤʤ���ϲ��������̤������С����Ƥ����ǽ��������ޤ���<br />
(�����С��λ��;塢���顼���Фޤ���)</div>
			<p></p>

		</fieldset>
 		<input type="hidden" name="mode" id="mode" value="Check" />
    <button type="submit">��Ͽ����</button>
  </form>
</div>

</body>
</html>
