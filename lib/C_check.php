<?php
/**
 *汎用チェッククラス
 *
 *@author Tomoyuki Shibata
 *@create 2005/06/22
 *
*/

class InputCheck {

	var $message;
	
	/**
	 * コンストラクタ
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
	 * エラーメッセージの生成。
	 *
	 * @return string エラーメッセージ
	 * @access public
	 */
	function getMessage()
	{
		$msg = implode("<br />", $this->message);
		$this->message = array();
		return $msg;
	}

	/**
	 * 空/Nullチェック
	 *
	 * @param string チェック対象文字列
	 * @param string 対象フィールド名
	 * @param string エラーメッセージ
	 * @return boolean TRUE: 正常 FALSE: 不正
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
	 * E-mailチェック
	 *
	 * @param string チェック対象文字列
	 * @param string 対象フィールド名
	 * @return boolean TRUE: 正常 FALSE: 不正
	 * @access public
	 */
	function isValidEMail($arg, $field = "")
	{
		$ret = TRUE;
		// 引数が存在しない時は正常扱いにする
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		// マルチバイトがあった場合は異常とする。
		if (ereg("[^!-~]", $arg)) {
			$ret = FALSE;
		}
		//「@」が必ず1つ以上ない場合は異常とする
		if (substr_count($arg, "@") != 1) {
			$ret = FALSE;
		}
		// 「.」は1つ以上ない又は最初または最後にある場合は異常とする
		if (substr_count($arg, ".") < 1 || substr($arg, strlen($arg) - 1) == "." || substr($arg, 0, 1) == ".") {
			$ret = FALSE;
		}
		// メールに使えない文字が含まれている場合は異常とする
		if (!ereg('^[^]()<>,;:"[]+$', $arg)) {
			$ret = FALSE;
		}
		// エラーメッセージを生成
		if (!$ret) {
			if ($field != "") {
				array_push($this->message, "※".$field."を正しいE-mail形式で入力して下さい");
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 電話番号チェック
	 *
	 * @param string チェック対象文字列
	 * @param string 対象フィールド名
	 * @return boolean TRUE: 正常 FALSE: 不正
	 * @access public
	 */
	function isValidTelNo($arg, $field = "")
	{
		// 引数が存在しない時は正常扱いにする
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		// 使用文字を制限（区切り記号を増やす際は追加する）
		if (ereg("[^0-9\(\)-]",$arg)){
			if($field != "")
//				$this->message .= $field."を正しい電話番号形式で入力して下さい".$this->br;
				array_push($this->message, "※".$field."を正しい電話番号形式で入力して下さい");
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * 桁数チェック
	 *
	 * @param  string  対象文字列
	 * @param  integer 最大桁数
	 * @param  integer 最小桁数（デフォルト:0)
	 * @param  string  対象フィールド名
	 * @param  boolean TRUE:マルチバイト対応（デフォルト） FALSE:バイト単位
	 * @param  string  対象文字コード(空の場合はスクリプトの内部コードと合わせる)
	 * @return boolean TRUE:正常 FALSE:不正
	 * @access public
	 */
	function isValidLength($arg, $max, $min = 0, $field = "", $multibyte = FALSE, $charset = INTERNAL_ENCODING)
	{
		// 必須でなく引数が存在しない時は正常扱いにする
		if ($min == 0 && (InputCheck::isEmpty($arg))) {
			return TRUE;
		}
		// 桁数取得
			$length = strlen($arg);
		// 最小桁数チェック
		if ($min > 0 && $min > $length) {
			if ($field != "") {
				if ($multibyte) {
					$msg = "※".$field."は全角".floor($min/2)."文字（半角".$min."文字）以上入力して下さい。";
				} else {
					$msg = "※".$field."は半角".$min."文字以上入力して下さい。";
				}
				array_push($this->message, $msg);
			}
			return FALSE;
		}
		// 最大桁数チェック
		if ($max < $length) {
			if ($field != "") {
				if ($multibyte) {
					$msg = "※".$field."は全角".floor($max/2)."文字（半角".$max."文字）以内で入力して下さい。";
				} else {
					$msg = "※".$field."は半角".$max."文字以内で入力して下さい。";
				}
				array_push($this->message, $msg);
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 半角チェックを行う
	 *
	 * @param string チェック対象文字列
	 * @param string 対象フィールド名
	 * @return boolean TRUE: 正常 FALSE: 不正
	 * @access public
	 */
	function isHankaku($arg, $field = "")
	{
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}

		if (ereg("[^!-~ ]",$arg)) {
			if($field != "")
//				$this->message .= $field."を半角文字列で入力して下さい".$this->br;
				array_push($this->message, "※".$field."を半角文字列で入力して下さい");

			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * 半角英数チェックを行う
	 *
	 * @param string チェック対象文字列
	 * @param string 対象フィールド名
	 * @return boolean TRUE: 正常 FALSE: 不正
	 * @access public
	 */
	function isHankakuNA($arg, $field = "")
	{
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		if (ereg("[^a-zA-Z0-9]", $arg)) {
			if ($field != "") {
				array_push($this->message, "※".$field."は半角英数字で入力して下さい");
			}
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 半角数字チェックを行う
	 *
	 * @param string チェック対象文字列
	 * @param string 対象フィールド名
	 * @return boolean TRUE: 正常 FALSE: 不正
	 * @access public
	 */
	function isHankakuN($arg, $field = "")
	{
		if (InputCheck::isEmpty($arg)) {
			return TRUE;
		}
		if (ereg("[^0-9]", $arg)) {
			if ($field != "") {
				array_push($this->message, "※".$field."は半角数字で入力して下さい");
			}
			return FALSE;
		}
		return TRUE;
	}


}
?>
