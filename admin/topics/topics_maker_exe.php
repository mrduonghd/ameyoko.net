<?php
session_start();

require_once('../../lib/Common_function.php');
require_once('../../lib/C_check.php');

mb_language("Japanese");
mb_internal_encoding("EUC-JP");


//����������å�
login_check();

//��Ͽ
if($_REQUEST['mode'] == 'Reg'){

	$shop_no               = $_SESSION['shop_no'];
	$topics_no             = $_SESSION['topics']['topics_no'];

	
	$title                 = Input_format($_SESSION['topics']['title']);
	$title_e               = Input_format($_SESSION['topics']['title_e']);
	$body                  = $_SESSION['topics']['body'];
	$body_e                = $_SESSION['topics']['body_e'];
	$status                = Input_format($_SESSION['topics']['status']);
	$template              = Input_format($_SESSION['topics']['template']);

	$update = date("Y/m/j H:i:s");
	
	$i_name = $_SESSION['topics']['images_name'];

	//���������ξ��
	if($topics_no){

		$sql = <<<EOF

update t_topics set
	
	title                = '$title',
	title_e              = '$title_e',
	body                 = '$body',
	body_e               = '$body_e',
	status               = '$status',
	template             = '$template'
	
where shop_no = '$shop_no' and topics_no = '$topics_no'

EOF;

		execsql($sql);
	
	}else{

		$topics_no = pg_result(execsql("select nextval('s_topics_no')"),0,nextval);
	
		$sql = <<<EOF
	
insert into t_topics(
	topics_no,
	shop_no,
	title,
	title_e,
	body,
	body_e,
	status,
	template,
	update
	)
	
values(
	'$topics_no',
	'$shop_no',
	'$title',
	'$title_e',
	'$body',
	'$body_e',
	'$status',
	'$template',
	'$update'
	)

EOF;

		execsql($sql);
	}
	
	//������ư
	
	//�����¸��
	$tmp_dir = "./tmp/" . $_SESSION['shop_no'];

	//������¸��
	$img_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/t_images/" . $_SESSION['shop_no'];
	$thumb_dir = $_SERVER['DOCUMENT_ROOT'] . "/shop/t_images/" . $_SESSION['shop_no'] . "/thumb";

if(!is_dir($img_dir)) {
		mkdir($img_dir, 0777);
	}
if(!is_dir($thumb_dir)) {
		mkdir($thumb_dir, 0777);
	}

	$image_count = "5";
	for($i=0;$i<$image_count;$i++){
		$n = $i + 1;
		if(file_exists($tmp_dir . "/" . $i . ".jpg")){
			$tmp_image_name[$i] = $tmp_dir . "/" . $i . ".jpg";
			$new_image_name[$i] = $img_dir . "/" . $topics_no . "_" . $n . ".jpg";
			$thumb_image_name[$i] = $thumb_dir . "/" . $topics_no . "_" . $n . ".jpg";
		}
		//�������
		if($_SESSION['topics']['image_del'][$i]){
			unlink($img_dir . "/" . $_SESSION['topics']['image_del'][$i]);
			unlink($img_dir . "/thumb/" . $_SESSION['topics']['image_del'][$i]);
		}

		if(file_exists($tmp_image_name[$i])){

			//�����ꥵ����
			$length = "600";//Ĺ���ۤ��Υ�����
			list($o_width, $o_height) = getimagesize($tmp_image_name[$i]);
			if($o_width > $o_height){//��Ĺ
				$height = ($o_height / $o_width) * $length;
				$width = $length;
			}else{//��Ĺ
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
			
			
			//����ͥ���
			$length = "120";//Ĺ���ۤ��Υ�����
			
			list($o_width, $o_height) = getimagesize($new_image_name[$i]);
			if($o_width > $o_height){//��Ĺ
				$height = ($o_height / $o_width) * $length;
				$width = $length;
			}else{//��Ĺ
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

}else{

	header("Location: ../") ;

}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" />
<title>�����餻������λ</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="login">
������Ź��̾��<strong><?php echo $_SESSION['shop_name'] ?></strong>��
<a href="../logout.php">�������Ȥ���</a>  | <a href="../">��˥塼�����</a>
</div>

<div id="stylized" class="myform">
  <h1>�������ޤ�����</h1>
	<p><a href="./">�����餻���������</a></p>
	<p><a href="../">��˥塼�����</a></p>
</div>

</body>
</html>
