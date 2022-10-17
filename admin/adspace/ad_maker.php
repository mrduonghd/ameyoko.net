<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../js/fckeditor/fckeditor.php');

//����������å�
login_check();


//��Ͽ
if($_REQUEST['mode'] == 'Check'){

	$_SESSION['ad']['title']        = $_REQUEST['title'];
	$_SESSION['ad']['body']         = $_REQUEST['body'];
	$_SESSION['ad']['url']          = $_REQUEST['url'];
	$_SESSION['ad']['image_del']    = $_REQUEST['image_del'];
	$_SESSION['ad']['status']       = $_REQUEST['status'];

	//�����ͥ����å�
	$InputCheck = new InputCheck();


	//	�����ȥ��NULL��
	if ($InputCheck->isEmpty($_SESSION['ad']['title'], 1, "�������ȥ�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['ad']['title'],50,0, "�����ȥ�")) { //��������å�
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
		$_SESSION['ad']['title'] = '';
	}else{
		$_SESSION['Error']['title'] = '';
	}

	//	��ʸ��NULL��
	if ($InputCheck->isEmpty($_SESSION['ad']['body'], 1, "����ʸ�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['body'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['ad']['body'],100,0, "��ʸ")) { //��������å�
		$_SESSION['Error']['body'] = ' style="background:#FFCC66"';
		$_SESSION['ad']['body'] = '';
	}else{
		$_SESSION['Error']['body'] = '';
	}
	
	if ($InputCheck->message) {
		$_SESSION['Error']['error_msg'] = $InputCheck->getMessage();
		header("Location: ./ad_maker.php?mode=Rewrite") ;
	}else{
	
	//�����ط�
	//�����¸��
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];
	if(!is_dir($tmp_dir)) {
		mkdir($tmp_dir, 0777, true);
	}
	
	$image_count = "1";
	for($i=0;$i<$image_count;$i++){
		//��¸�ΰ���ե��������
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

//���ɽ��
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

		//�����ϰ������
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
<title>�������</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
������Ź��̾��<strong><?php echo $_SESSION['shop_name'] ?></strong>��
<a href="../logout.php">�������Ȥ���</a>  | <a href="../">��˥塼�����</a>
</div>
<div id="stylized" class="myform">

<?php if($today_flg): ?>

�����Τ����餻�ϰ�����󤷤������Ǥ��ޤ���<br />
���������������Τ餻���ѹ����Ƥ���������
	<p><a href="./">�����餻���������</a></p>

<?php else: ?>

  <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <h1>�������</h1>
		<?php if($_SESSION['Error']['error_msg']): ?>
		<div class="caution">
		<?php echo $_SESSION['Error']['error_msg'] ?>
		</div>
		<?php endif; ?>

			<label>�����ȥ�<span class="small">����25ʸ������ / <span style="color:#FF0000">*html���������Բ�</span></span></label>
			<input name="title" type="text" id="title" value="<?php echo $_SESSION['ad']['title'] ?>"<?php echo $_SESSION['Error']['title'] ?> maxlength="25" />
     	<div class="spacer"></div>
						
			<label>���Τ餻��ʸ<span class="small">����50ʸ������ / <span style="color:#FF0000">*html���������Բ�</span></span></label>
			
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
			<label>����<?php echo $n ?><span class="small">��ưŪ��Ŭ���������˥ꥵ��������ޤ�<br />
    �б��ե����ޥåȤϡ�jpg�פǤ�</span></label>
			<input type="file" size="32" name="t_images[]" value="" /><br />
			<?php if(file_exists($img_name = $img_dir . "/" . $topad_no . "_" . $n . ".jpg")): 	?>
			<div class="spacer"></div>
			
			<div align="center">������Ͽ����Ƥ������:<input type="checkbox" name="image_del[]" id="image_del[]" value="<?php echo $topad_no . "_" . $n . ".jpg" ?>" />���������ϥ����å����Ƥ�������<br />
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

		<label>�����url<span class="small">̤���ϻ���Ź�޾Ҳ�ڡ����إ�󥯤��ޤ�</span></label>
			<input type="text" name="url" id="url" value="<?php echo $_SESSION['ad']['url'] ?>" />
     	<div class="spacer"></div>

		<label>�Ǻܾ���<span class="small">�Ǻܤ���Ū�ˤ��������ɽ���ˤ��Ƥ�������</span></label>
			<input name="status" type="radio" id="status" value="1"<?php if($_SESSION['ad']['status'] == "1" or !$_SESSION['ad']['status']): ?>  checked="checked"<?php endif; ?> />
	    ɽ�� | <input type="radio" name="status" id="status" value="2"<?php if($_SESSION['ad']['status'] == "2"): ?> checked="checked"<?php endif; ?> />��ɽ��
    	<div class="spacer"></div>
			<br />
			<br />

		<input type="hidden" name="mode" id="mode" value="Check" />
		<button type="submit">��Ͽ����</button>
    <div class="spacer"></div>
  </form>

<?php endif; ?>

</div>

</body>
</html>
