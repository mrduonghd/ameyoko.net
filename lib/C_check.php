<?php
/**
 *���ѥ����å����饹
 *
 *@author Tomoyuki Shibata
 *@create 2005/06/22
 *
*/

class InputCheck {

	var $message;
	
	/**
	 * ���󥹥ȥ饯��
	 */
	function InputCheck()
	{
		$this->clear();
	}

	
	function clear()
	{
		$this->message = array();
	}

	/**
	 * ���顼��å�������������
	 *
	 * @return string ���顼��å�����
	 * @access public
	 */
	function getMessage()
	{
		$msg = implode("<br />", $this->message);
		$this->message = array();
		return $msg;
	}

	/**
	 * ��/Null�����å�
	 *
	 * @param string �����å��о�ʸ����
	 * @param string �оݥե������̾
	 * @param string ���顼��å�����
	 * @return boolean TRUE: ���� FALSE: ����
	 * @access public
	 */

	function isEmpty($arg, $field = "", $error_msg = "")
	{
		$arg = trim($arg);
		if (!isset($arg) || $arg === "" || is_null($arg)) {
			if ($field != "") {
				array_push($this->message, $error_msg);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * E-mail�����å�
	 *
	 * @param string �����å��о�ʸ����
	 * @param string �оݥե������̾
	 * @return boolean TRUE: ���� FALSE: ����
	 * @access public
	 */
	function isValidEMail($arg, $field = "")
	{
		$ret = TRUE;
		// ������¸�ߤ��ʤ��������ﰷ���ˤ���
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		// �ޥ���Х��Ȥ����ä����ϰ۾�Ȥ��롣
		if (ereg("[^!-~]", $arg)) {
			$ret = FALSE;
		}
		//��@�פ�ɬ��1�İʾ�ʤ����ϰ۾�Ȥ���
		if (substr_count($arg, "@") != 1) {
			$ret = FALSE;
		}
		// ��.�פ�1�İʾ�ʤ����Ϻǽ�ޤ��ϺǸ�ˤ�����ϰ۾�Ȥ���
		if (substr_count($arg, ".") < 1 || substr($arg, strlen($arg) - 1) == "." || substr($arg, 0, 1) == ".") {
			$ret = FALSE;
		}
		// �᡼��˻Ȥ��ʤ�ʸ�����ޤޤ�Ƥ�����ϰ۾�Ȥ���
		if (!ereg('^[^]()<>,;:"[]+$', $arg)) {
			$ret = FALSE;
		}
		// ���顼��å�����������
		if (!$ret) {
			if ($field != "") {
				array_push($this->message, "��".$field."��������E-mail���������Ϥ��Ʋ�����");
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * �����ֹ�����å�
	 *
	 * @param string �����å��о�ʸ����
	 * @param string �оݥե������̾
	 * @return boolean TRUE: ���� FALSE: ����
	 * @access public
	 */
	function isValidTelNo($arg, $field = "")
	{
		// ������¸�ߤ��ʤ��������ﰷ���ˤ���
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		// ����ʸ�������¡ʶ��ڤ국������䤹�ݤ��ɲä����
		if (ereg("[^0-9\(\)-]",$arg)){
			if($field != "")
//				$this->message .= $field."�������������ֹ���������Ϥ��Ʋ�����".$this->br;
				array_push($this->message, "��".$field."�������������ֹ���������Ϥ��Ʋ�����");
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * ��������å�
	 *
	 * @param  string  �о�ʸ����
	 * @param  integer ������
	 * @param  integer �Ǿ�����ʥǥե����:0)
	 * @param  string  �оݥե������̾
	 * @param  boolean TRUE:�ޥ���Х����б��ʥǥե���ȡ� FALSE:�Х���ñ��
	 * @param  string  �о�ʸ��������(���ξ��ϥ�����ץȤ����������ɤȹ�碌��)
	 * @return boolean TRUE:���� FALSE:����
	 * @access public
	 */
	function isValidLength($arg, $max, $min = 0, $field = "", $multibyte = FALSE, $charset = INTERNAL_ENCODING)
	{
		// ɬ�ܤǤʤ�������¸�ߤ��ʤ��������ﰷ���ˤ���
		if ($min == 0 && (InputCheck::isEmpty($arg))) {
			return TRUE;
		}
		// �������
			$length = strlen($arg);
		// �Ǿ���������å�
		if ($min > 0 && $min > $length) {
			if ($field != "") {
				if ($multibyte) {
					$msg = "��".$field."������".floor($min/2)."ʸ����Ⱦ��".$min."ʸ���˰ʾ����Ϥ��Ʋ�������";
				} else {
					$msg = "��".$field."��Ⱦ��".$min."ʸ���ʾ����Ϥ��Ʋ�������";
				}
				array_push($this->message, $msg);
			}
			return FALSE;
		}
		// �����������å�
		if ($max < $length) {
			if ($field != "") {
				if ($multibyte) {
					$msg = "��".$field."������".floor($max/2)."ʸ����Ⱦ��".$max."ʸ���˰�������Ϥ��Ʋ�������";
				} else {
					$msg = "��".$field."��Ⱦ��".$max."ʸ����������Ϥ��Ʋ�������";
				}
				array_push($this->message, $msg);
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Ⱦ�ѥ����å���Ԥ�
	 *
	 * @param string �����å��о�ʸ����
	 * @param string �оݥե������̾
	 * @return boolean TRUE: ���� FALSE: ����
	 * @access public
	 */
	function isHankaku($arg, $field = "")
	{
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}

		if (ereg("[^!-~ ]",$arg)) {
			if($field != "")
//				$this->message .= $field."��Ⱦ��ʸ��������Ϥ��Ʋ�����".$this->br;
				array_push($this->message, "��".$field."��Ⱦ��ʸ��������Ϥ��Ʋ�����");

			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * Ⱦ�ѱѿ������å���Ԥ�
	 *
	 * @param string �����å��о�ʸ����
	 * @param string �оݥե������̾
	 * @return boolean TRUE: ���� FALSE: ����
	 * @access public
	 */
	function isHankakuNA($arg, $field = "")
	{
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		if (ereg("[^a-zA-Z0-9]", $arg)) {
			if ($field != "") {
				array_push($this->message, "��".$field."��Ⱦ�ѱѿ��������Ϥ��Ʋ�����");
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Ⱦ�ѿ��������å���Ԥ�
	 *
	 * @param string �����å��о�ʸ����
	 * @param string �оݥե������̾
	 * @return boolean TRUE: ���� FALSE: ����
	 * @access public
	 */
	function isHankakuN($arg, $field = "")
	{
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		if (ereg("[^0-9]", $arg)) {
			if ($field != "") {
				array_push($this->message, "��".$field."��Ⱦ�ѿ��������Ϥ��Ʋ�����");
			}
			return FALSE;
		}
		return TRUE;
	}


}
?>
