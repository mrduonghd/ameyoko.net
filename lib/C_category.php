<?php
/**
 *�ȼ��Ϣ���饹
 *
 *@author Tomoyuki Shibata
 *@create 2008/10/21
 *
*/

class Category {

	/**
	 * �ȼ����
	 *
	 * @var    array
	 * @access private
	 */
	var $cCategory;


	/**
	 * ���󥹥ȥ饯��
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
	 * �ǡ����١����������������������
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
