<?php
/**
 *店舗情報クラス
 *
 *@author Tomoyuki Shibata
 *@create 2008/10/22
 *
 */

class Shop_info {

	/**
	 * 店舗情報
	 *
	 * @var    array
	 * @access private
	 */
	var $cShop_info;
	var $cShop_topics;
	var $cShop_coupon;
	var $cShop_job_offer;
	var $cShop_item;
	var $cTop_topics_list;
	var $cSearch_shop;


	/**
	 * コンストラクタ
	 */
	function Shop_info()
	{
		$this->clear();
	}


	function clear()
	{
		$this->cShop_info = array();
		$this->cShop_topics = array();
		$this->cShop_coupon = array();
		$this->cShop_job_offer = array();
		$this->cShop_item = array();
		$this->cTop_topics_list = array();
		$this->cSearch_shop = array();
	}

	/**
	 * データベースより店舗情報を取得する
	 *
	 * @access public
	 */
	function get_Shop_info($arg = "")
	{
		$r = execsql("select * from m_shop " . $arg);
		if($num = pg_num_rows($r)){
			for($i=0;$i<$num;$i++){
				$this->cShop_info[$i]['area_no']                      = pg_result($r,$i,"area_no");
				$this->cShop_info[$i]['shop_no']                      = pg_result($r,$i,"shop_no");
				$this->cShop_info[$i]['branch_no']                    = pg_result($r,$i,"branch_no");
				$this->cShop_info[$i]['shop_id']                      = pg_result($r,$i,"shop_id");
				$this->cShop_info[$i]['shop_passwd']                  = pg_result($r,$i,"shop_passwd");
				$this->cShop_info[$i]['shop_name']                    = pg_result($r,$i,"shop_name");
				$this->cShop_info[$i]['shop_name_e']                  = pg_result($r,$i,"shop_name_e");
				$this->cShop_info[$i]['shop_name_k']                  = pg_result($r,$i,"shop_name_k");
				$this->cShop_info[$i]['shop_name_c']                  = pg_result($r,$i,"shop_name_c");
				$this->cShop_info[$i]['shop_kana']                    = pg_result($r,$i,"shop_kana");
				$this->cShop_info[$i]['m_shop_name']                  = pg_result($r,$i,"m_shop_name");
				$this->cShop_info[$i]['m_shop_name_e']                = pg_result($r,$i,"m_shop_name_e");
				$this->cShop_info[$i]['m_shop_name_k']                = pg_result($r,$i,"m_shop_name_k");
				$this->cShop_info[$i]['m_shop_name_c']                = pg_result($r,$i,"m_shop_name_c");
				$this->cShop_info[$i]['category_no']                  = pg_result($r,$i,"category_no");
				$this->cShop_info[$i]['map_no']                       = pg_result($r,$i,"map_no");
				$this->cShop_info[$i]['address']                      = pg_result($r,$i,"address");
				$this->cShop_info[$i]['address_e']                    = pg_result($r,$i,"address_e");
				$this->cShop_info[$i]['address_k']                    = pg_result($r,$i,"address_k");
				$this->cShop_info[$i]['address_c']                    = pg_result($r,$i,"address_c");
				$this->cShop_info[$i]['tel']                          = pg_result($r,$i,"tel");
				$this->cShop_info[$i]['fax']                          = pg_result($r,$i,"fax");
				$this->cShop_info[$i]['business_hours']               = pg_result($r,$i,"business_hours");
				$this->cShop_info[$i]['regular_holiday']              = pg_result($r,$i,"regular_holiday");
				$this->cShop_info[$i]['regular_holiday_e']            = pg_result($r,$i,"regular_holiday_e");
				$this->cShop_info[$i]['regular_holiday_k']            = pg_result($r,$i,"regular_holiday_k");
				$this->cShop_info[$i]['regular_holiday_c']            = pg_result($r,$i,"regular_holiday_c");
				$this->cShop_info[$i]['select_line']                  = pg_result($r,$i,"select_line");
				$this->cShop_info[$i]['select_line_e']                = pg_result($r,$i,"select_line_e");
				$this->cShop_info[$i]['select_line_k']                = pg_result($r,$i,"select_line_k");
				$this->cShop_info[$i]['select_line_c']                = pg_result($r,$i,"select_line_c");
				$this->cShop_info[$i]['sales']                        = pg_result($r,$i,"sales");
				$this->cShop_info[$i]['payment']                      = pg_result($r,$i,"payment");
				$this->cShop_info[$i]['card']                         = pg_result($r,$i,"card");
				$this->cShop_info[$i]['url']                          = pg_result($r,$i,"url");
				$this->cShop_info[$i]['email']                        = pg_result($r,$i,"email");
				$this->cShop_info[$i]['charge']                       = pg_result($r,$i,"charge");
				$this->cShop_info[$i]['charge_e']                     = pg_result($r,$i,"charge_e");
				$this->cShop_info[$i]['comment']                      = html_entity_decode(pg_result($r,$i,"comment"));
				$this->cShop_info[$i]['comment_e']                    = html_entity_decode(pg_result($r,$i,"comment_e"));
				$this->cShop_info[$i]['comment_k']                    = html_entity_decode(pg_result($r,$i,"comment_k"));
				$this->cShop_info[$i]['comment_c']                    = html_entity_decode(pg_result($r,$i,"comment_c"));
				$this->cShop_info[$i]['status']                       = pg_result($r,$i,"status");
				$this->cShop_info[$i]['priority']                     = pg_result($r,$i,"priority");
				$this->cShop_info[$i]['tmp1']                         = pg_result($r,$i,"tmp1");
				$this->cShop_info[$i]['tmp2']                         = pg_result($r,$i,"tmp2");
				$this->cShop_info[$i]['tmp3']                         = pg_result($r,$i,"tmp3");
				$this->cShop_info[$i]['regdate']                      = pg_result($r,$i,"regdate");
				$this->cShop_info[$i]['update']                       = pg_result($r,$i,"update");
			}
			$this->cShop_info['count'] = $num;
			return $this->cShop_info;
		}else{
			return 0;
		}
	}

	/**
	 * おしらせ
	 *
	 * @access public
	 */

	function get_Shop_topics($arg = "")
	{
		$r = execsql("select * from t_topics " . $arg);
		if($num = pg_num_rows($r)){
			$this->cShop_topics['num']                             = $num;
			for($i=0;$i<$num;$i++){
				$this->cShop_topics[$i]['topics_no']                   = pg_result($r,$i,"topics_no");
				$this->cShop_topics[$i]['title']                       = pg_result($r,$i,"title");
				$this->cShop_topics[$i]['body']                        = html_entity_decode(pg_result($r,$i,"body"));
				$this->cShop_topics[$i]['template']                    = pg_result($r,$i,"template");
				$this->cShop_topics[$i]['status']                      = pg_result($r,$i,"status");
				$this->cShop_topics[$i]['update']                      = pg_result($r,$i,"update");
			}
		}
	}


	/**
	 * クーポン
	 *
	 * @access public
	 */

	function get_Shop_coupon($arg = "")
	{
		$r = execsql("select * from t_coupon " . $arg);
		if($num = pg_num_rows($r)){
			$this->cShop_coupon['num']                             = $num;
			for($i=0;$i<$num;$i++){
				$this->cShop_coupon[$i]['shop_no']                     = pg_result($r,$i,"shop_no");
				$this->cShop_coupon[$i]['coupon_no']                   = pg_result($r,$i,"coupon_no");
				$this->cShop_coupon[$i]['title']                       = pg_result($r,$i,"title");
				$this->cShop_coupon[$i]['body']                        = html_entity_decode(pg_result($r,$i,"body"));
				$this->cShop_coupon[$i]['status']                      = pg_result($r,$i,"status");
				$this->cShop_coupon[$i]['expiration']                  = pg_result($r,$i,"expiration");
				$this->cShop_coupon[$i]['update']                      = pg_result($r,$i,"update");
			}
		}
	}


	/**
	 * 求人情報
	 *
	 * @access public
	 */

	function get_Shop_job_offer($arg = "")
	{
		$r = execsql("select * from t_job_offer " . $arg);
		if($num = pg_num_rows($r)){
			$this->cShop_job_offer['num']                             = $num;
			for($i=0;$i<$num;$i++){
				$this->cShop_job_offer[$i]['shop_no']                     = pg_result($r,$i,"shop_no");
				$this->cShop_job_offer[$i]['job_offer_no']                = pg_result($r,$i,"job_offer_no");
				$this->cShop_job_offer[$i]['title']                       = pg_result($r,$i,"title");
				$this->cShop_job_offer[$i]['body']                        = html_entity_decode(pg_result($r,$i,"body"));
				$this->cShop_job_offer[$i]['status']                      = pg_result($r,$i,"status");
				$this->cShop_job_offer[$i]['expiration']                  = pg_result($r,$i,"expiration");
				$this->cShop_job_offer[$i]['update']                      = pg_result($r,$i,"update");
			}
		}
	}


	/**
	 * 商品
	 *
	 * @access public
	 */

	function get_Shop_item($arg = "")
	{
		$r = execsql("select * from t_item " . $arg);
		if($num = pg_num_rows($r)){
			$this->cShop_item['num']                              = $num;
			for($i=0;$i<$num;$i++){
				$this->cShop_item[$i]['item_no']                      = pg_result($r,$i,"item_no");
				$this->cShop_item[$i]['item_name']                    = pg_result($r,$i,"item_name");
				$this->cShop_item[$i]['comment']                      = html_entity_decode(pg_result($r,$i,"comment"));
				$this->cShop_item[$i]['status']                       = pg_result($r,$i,"status");
				$this->cShop_item[$i]['update']                       = pg_result($r,$i,"update");
			}
		}
	}


	//トップページおしらせ一覧
	function get_Top_topics_list($arg = "")
	{
//		$r = execsql("select * from v_topics_list order by update DESC;");
//		$r = execsql("select v.shop_no,v.title,v.update from v_topics_list as v,m_shop as m where v.shop_no = m.shop_no and m.status = 1  order by v.update DESC;");

		$r = execsql("select v_topics_list.shop_no,v_topics_list.title,v_topics_list.update from v_topics_list ,m_shop  where v_topics_list.shop_no = m_shop.shop_no and m_shop.status = '1'  order by v_topics_list.update DESC;");

		if($num = pg_num_rows($r)){
			if($num > 20){ $num = 20; }
			$this->cTop_topics_list['num']                             = $num;
			for($i=0;$i<$num;$i++){
				$this->cTop_topics_list[$i]['shop_no']                     = pg_result($r,$i,"shop_no");
				$this->cTop_topics_list[$i]['title']                       = pg_result($r,$i,"title");
				$this->cTop_topics_list[$i]['update']                      = pg_result($r,$i,"update");

				$this->get_Shop_info("where shop_no = '" . $this->cTop_topics_list[$i]['shop_no'] . "'");
				$this->cTop_topics_list[$i]['shop_name']                   = $this->cShop_info[0]['shop_name'] ;
			}
		}
	}


	/**
	 * 検索用店舗リストを取得
	 *
	 * @access public
	 */
	function get_Search_shop($arg = "")
	{

		$sql = "select m.shop_no,COUNT(*),m.shop_kana,m.shop_name,m.shop_name_e from m_shop as m , r_shop_category as r ". $arg;

		$r = execsql($sql);
		if($num = pg_num_rows($r)){
			for($i=0;$i<$num;$i++){
				$this->cSearch_shop[$i]['shop_no']                      = pg_result($r,$i,"shop_no");
				$this->cSearch_shop[$i]['shop_name']                    = pg_result($r,$i,"shop_name");
				$this->cSearch_shop[$i]['shop_name_e']                  = pg_result($r,$i,"shop_name_e");
			}
			$this->cSearch_shop['count'] = $num;
			return $this->cSearch_shop;

		}else{
			return 0;
		}
	}



	//トップページ広告一覧
	function get_Top_ad_list($arg = "")
	{
		$r = execsql("select * from t_topad where status = '1' and priority = '". $arg."' order by RANDOM();");
		if($num = pg_num_rows($r)){
			$this->cTop_ad_list['num']                             = $num;
			for($i=0;$i<$num;$i++){
				$this->cTop_ad_list[$i]['topad_no']                     = pg_result($r,$i,"topad_no");
				$this->cTop_ad_list[$i]['shop_no']                     = pg_result($r,$i,"shop_no");
				$this->cTop_ad_list[$i]['title']                       = pg_result($r,$i,"title");
				$this->cTop_ad_list[$i]['body']                        = html_entity_decode(pg_result($r,$i,"body"));
				$this->cTop_ad_list[$i]['url']                         = html_entity_decode(pg_result($r,$i,"url"));

				$this->get_Shop_info("where shop_no = '" . $this->cTop_ad_list[$i]['shop_no'] . "'");
				$this->cTop_ad_list[$i]['shop_name']                   = $this->cShop_info[0]['shop_name'] ;
			}
		}
	}
}

?>
