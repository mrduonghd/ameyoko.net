<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');
require_once('../js/fckeditor/fckeditor.php');

//����������å�
admin_check();

//��Ͽ
if($_REQUEST['mode'] == 'Check'){

	$_SESSION['event']['title']        = $_REQUEST['title'];
	$_SESSION['event']['title_e']      = $_REQUEST['title_e'];
	$_SESSION['event']['body']         = $_REQUEST['body'];
	$_SESSION['event']['body_e']       = $_REQUEST['body_e'];
	$_SESSION['event']['image_del']    = $_REQUEST['image_del'];
	$_SESSION['event']['status']       = $_REQUEST['status'];

	//�����ͥ����å�
	$InputCheck = new InputCheck();


	//	�����ȥ��NULL��
	if ($InputCheck->isEmpty($_SESSION['event']['title'], 1, "�������ȥ�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
	}elseif (!$InputCheck->isValidLength($_SESSION['event']['title'],70,0, "�����ȥ�")) { //��������å�
		$_SESSION['Error']['title'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['title'] = '';
	}

	//	��ʸ��NULL��
	if ($InputCheck->isEmpty($_SESSION['event']['body'], 1, "�������餻��ʸ�����Ϥ��Ƥ���������")) {
		$_SESSION['Error']['body'] = ' style="background:#FFCC66"';
	}else{
		$_SESSION['Error']['body'] = '';
	}
	
	if ($InputCheck->message) {
		$_SESSION['Error']['error_msg'] = $InputCheck->getMessage();
		header("Location: ./event_maker.php?mode=Rewrite") ;
	}else{
	
	//�����ط�
	//�����¸��
	$tmp_dir = "./tmp_dir";
	if(!is_dir($tmp_dir)) {
		mkdir($tmp_dir, 0777);
	}
	
	$image_count = "5";
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
		header("Location: ./event_maker_exe.php?mode=Reg");
	}

}

//���ɽ��
if($_REQUEST['mode'] != 'Rewrite' and $_REQUEST['mode'] != 'Check'){
	
	$_SESSION['event']['event_no'] = $_REQUEST['event_no'];

	if($event_no = $_SESSION['event']['event_no']){
		$result = execsql("select * from t_event where event_no = '$event_no'");
		if(pg_num_rows($result)){
	
			$_SESSION['event']['title']                 = pg_result($result,0,'title');
			$_SESSION['event']['title_e']               = pg_result($result,0,'title_e');
			$_SESSION['event']['template']              = pg_result($result,0,'template');
			$_SESSION['event']['body']                  = pg_result($result,0,'body');
			$_SESSION['event']['body_e']                = pg_result($result,0,'body_e');
			$_SESSION['event']['status']                = pg_result($result,0,'status');
	
		}else{
            unset($_SESSION['Error']);
		}
	}else{
        unset($_SESSION['Error']);
	}

    unset($_SESSION['Error']);

}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>���٥�Ⱦ������</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        img.event-img {
            max-width: 100%;
        }
    </style>
</head>

<body>
<?=$tmp_name[0]?>
<div id="login">
<a href="../logout.php">�������Ȥ���</a>  | <a href="../admin.php">��˥塼�����</a>
</div>

<div id="stylized" class="myform">


	<p><a href="./">���٥�Ⱦ�����������</a></p>

  <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <h1>���٥�Ⱦ������</h1>
		<?php if($_SESSION['Error']['error_msg']): ?>
		<div class="caution">
		<?php echo $_SESSION['Error']['error_msg'] ?>
		</div>
		<?php endif; ?>

			<label>�����ȥ�<span class="small">����35ʸ������ / <span style="color:#FF0000">*html���������Բ�</span></span></label>
			<input name="title" type="text" id="title" value="<?php echo $_SESSION['event']['title'] ?>"<?php echo $_SESSION['Error']['title'] ?> />
     	<div class="spacer"></div>
			
			<label>�����ȥ�(�Ѹ�ɽ��)<span class="small">Ⱦ��35ʸ������ / <span style="color:#FF0000">*html���������Բ�</span></span></label>
			<input type="text" name="title_e" id="title_e" value="<?php echo $_SESSION['event']['title_e'] ?>" />
     	<div class="spacer"></div>
			
			<label>���Τ餻��ʸ<span class="small">html�������Ѳ�ǽ�Ǥ���</span></label>
			<?php
			$oFCKeditor = new FCKeditor('body') ;
			$oFCKeditor->BasePath = '../js/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '400';
			$oFCKeditor->ToolbarSet = 'Ameyoko';
			$oFCKeditor->Value = $_SESSION['event']['body'];
			$oFCKeditor->Create() ;
			?>
     	<div class="spacer"></div>

 			<label>���Τ餻��ʸ(�Ѹ�ɽ��)<span class="small">html�������Ѳ�ǽ�Ǥ���</span></label>
			<?php
			$oFCKeditor = new FCKeditor('body_e') ;
			$oFCKeditor->BasePath = '../js/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '400';
			$oFCKeditor->ToolbarSet = 'Ameyoko';
			$oFCKeditor->Value = $_SESSION['event']['body_e'];
			$oFCKeditor->Create() ;
			?>
    	<div class="spacer"></div>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<?php
			$image_count = 5;
			$img_dir ="../../event/archive";
			for($i=0;$i<$image_count;$i++){
				$n = $i + 1;
			?>
			<p></p>
			<label>����<?php echo $n ?><span class="small">��ưŪ��Ŭ���������˥ꥵ��������ޤ�</span></label>
			<input type="file" size="32" name="t_images[]" value="" /><br />
			<?php if(file_exists($img_name = $img_dir . "/" . $event_no . "/" . $n . ".jpg")): 	?>
			<div class="spacer"></div>
			
			<div align="center">������Ͽ����Ƥ������:<input type="checkbox" name="image_del[]" id="image_del[]" value="<?php echo $n . ".jpg" ?>" />���������ϥ����å����Ƥ�������<br />
			<img class="event-img" src="<?php echo $img_name ?>" />
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

			<label>�Ǻܾ���<span class="small">�Ǻܤ���Ū�ˤ��������ɽ���ˤ��Ƥ�������</span></label>
			<input name="status" type="radio" id="status" value="1"<?php if($_SESSION['event']['status'] == "1" or !$_SESSION['event']['status']): ?>  checked="checked"<?php endif; ?> />
	    ɽ�� | <input type="radio" name="status" id="status" value="2"<?php if($_SESSION['event']['status'] == "2"): ?> checked="checked"<?php endif; ?> />��ɽ��
    	<div class="spacer"></div>
			<br />
			<br />

		<input type="hidden" name="mode" id="mode" value="Check" />
		<button type="submit">��Ͽ����</button>
    <div class="spacer"></div>
  </form>
</div>

</body>
</html>
