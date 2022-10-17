<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/Config.php");

 class  Shop{
   public static function ret_marketplace_shop_list($category ){
        $mp_shop_data_json = (file_get_contents('./marketplace_shop_data.json'));
        $arr_mp_shop_data = json_decode($mp_shop_data_json, true);
        if ($category =='all'){
            return mb_convert_encoding($arr_mp_shop_data,"EUC-JP", "auto");
        }else{
            foreach($arr_mp_shop_data as $mp_shop_data){
                if($mp_shop_data['category'] == $category){
                    $mp_shop_list[] = $mp_shop_data;
                }
            }
            return mb_convert_encoding($mp_shop_list,"EUC-JP", "auto");

        }
    }
   public static function ret_real_shop_list($category){
     $status = SHOP_STATUS_OPEN;
        $categoryRef = [
            'fashion' => '1,2',
            'shoes_bag_accessorie' => '3,6,9',
            'gourmet' => '11',
            'food' => '7',
            'sundry_goods' => '8,12,13',
            'cosme_drag' => '4,5',
            'leisure_other' => '10,14,15,16',
        ];
        if ($category != 'all') {
            $category_no = implode("','",explode(',', $categoryRef[$category]));
            $real_shop_list = <<<EOF
       SELECT shop_no
     , shop_name
     , tel || chr(10) || business_hours || chr(10) || regular_holiday AS shop_data
       FROM m_shop
       WHERE status = '$status'
       AND category_no IN ('$category_no')
       ORDER BY shop_name
EOF;
        }else{
            $real_shop_list = <<<EOF
      SELECT shop_no
     , shop_name
     , tel || chr(10) || business_hours || chr(10) || regular_holiday AS shop_data
      FROM m_shop
      WHERE status = '$status'
      ORDER BY shop_name
EOF;
        }
        $sql = execsql($real_shop_list,'EUC-JP');
       return pg_fetch_all($sql);

   }
   public static  function ret_shop_category_name($category){
        $message = '';
        switch($category) {
            case 'all':
            case '':
                $message = 'すべてのカテゴリ';
                break;

            case 'fashion':
                $message = 'ファッション';
                break;

            case 'shoes_bag_accessorie':
                $message = '靴・バック・小物';
                break;

            case 'gourmet':
                $message = 'グルメ';
                break;

            case 'food':
                $message = '食品';
                break;

            case 'sundry_goods':
                $message = '雑貨';
                break;

            case 'cosme_drag':
                $message = 'コスメ・薬';
                break;

            case 'leisure_other':
                $message = 'レジャー・その他';
                break;

        }
        return $message;
    }
   public static function ret_shop_data($shop_no){
       $status = SHOP_STATUS_OPEN;
       $shop_detail = <<<EOF
        SELECT shop_no
             , shop_name
             , address
             , tel
             , business_hours
             , regular_holiday
             , url
             , email
             , charge
             , comment
        FROM m_shop
        WHERE shop_no = '$shop_no'
        AND status = '$status'
EOF;
       $sql = execsql($shop_detail,'EUC-JP');
       return pg_fetch_all($sql);
    }
   public static function ret_marketplace_shop_data($shop_no){
       $mp_shop_data_json = file_get_contents('./marketplace_shop_data.json');
       $arr_mp_shop_data = json_decode($mp_shop_data_json, true);
       foreach($arr_mp_shop_data as $mp_shop_data){
           if($mp_shop_data['shop_no'] == $shop_no){
               return $mp_shop_data;
           }
       }
       return '';
   }
   public static function ret_google_map_url($shop_no){
       $map = <<<EOF
        SELECT url
        FROM r_shop_google_map_url
        WHERE shop_no = '$shop_no'
EOF;
       $sql = execsql($map,'EUC-JP');
       if($sql){
           $arr = pg_fetch_array($sql);
           return $arr['url'];
       }else{
           return '';
       }

   }

}


