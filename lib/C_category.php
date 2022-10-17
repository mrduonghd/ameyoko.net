<?php
/**
 *業種関連クラス
 *
 *@author Tomoyuki Shibata
 *@create 2008/10/21
 *
*/

class Category {

	/**
	 * 業種情報
	 *
	 * @var    array
	 * @access private
	 */
	var $cCategory;


	/**
	 * コンストラクタ
	 */
	function Category()
	{
		$this->clear();
	}

	
	function clear()
	{
		$this->cCategory = array();
	}

	/**
	 * データベースより仕入先情報を取得する
	 *
	 * @access public
	 */
	function get_Master_Category($arg = "")
	{
		$r = execsql("select * from m_category " . $arg);
		if($num = pg_num_rows($r)){
			for($i=0;$i<$num;$i++){
					$this->cCategory[$i][category_no] = pg_result($r,$i,"category_no");
					$this->cCategory[$i][category_name] = pg_result($r,$i,"category_name");
			}
			$this->cCategory['count'] = $num;
			return $this->cCategory;
		}else{
			return 0;
		}
	}


}
?>
