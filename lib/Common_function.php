<?php
require_once('Config.php');

/**
 * is_production
 * サーバーが本番環境かどうか判定する
 * @returns {boolean} true : 本番環境 false : 本番環境以外
 */
function is_production(){

    if ($_SERVER['SERVER_NAME'] == SERVER_NAME_PRODUCTION){
        return true;
    } else{
        return false;
    }

}


/**
 *   DBへの接続及び、SQLの実行をする関数
 *  引数 $sql : sql文
 *         $encode : DBのクライアントエンコーディング指定
 *  戻り値  成功した場合にクエリ結果リソース、失敗した場合 FALSE
 * @param string $sql
 * @param string $encode
 * @return resource
 */
function execsql($sql,$encode = "") {

    //DB接続実行
    $conn = pg_connect(is_production() ? DB_CONNECT_STRING_PROD: DB_CONNECT_STRING_DEV );
    if (!$conn) {
        die("unable to connect database server. " . pg_last_error());
    }

    //エンコード指定がある場合
    if ( $encode ){
        //現在のクライアントエンコーディングを退避
        $current_client_encoding = pg_client_encoding( $conn );

        //クライアントエンコーデングを変更
        pg_set_client_encoding( $conn , $encode );
    }

    //SQLを実行
    $result = pg_query( $conn , $sql );
    if(!$result){
        if (is_production()){
            die(1);
        }else{
            die("Failed to execute sql. " . pg_last_error());
        }
    }

    //エンコード指定がある場合
    if ( $encode ){
        //クライアントエンコーディングを戻す
        pg_set_client_encoding($conn, $current_client_encoding);
    }

    return ($result);

}

/**
 * EtoU($arg)
 * utf-8変換
 * 戻り値 : $arg
*/

function EtoU($arg) {
	$arg = mb_convert_encoding($arg,"utf-8","EUC-JP");
	return $arg;
}


/**
 * UtoE($arg)
 * EUC変換
 * 戻り値 : $arg
*/

function UtoE($arg) {
	$arg = mb_convert_encoding($arg,"EUC-JP","utf-8");
	return $arg;
}

/**
 * login_check ()
 * ログインチェック
 * 戻り値 : なし
*/
function login_check(){

	$shop_id       = $_SESSION['shop_id'];
	$shop_passwd   = $_SESSION['shop_passwd'];
//	$shop_no       = $_SESSION['shop_no'];

	if($shop_id and $shop_passwd){
		$r = execsql("select shop_no,shop_name from m_shop where shop_id = '$shop_id' and shop_passwd = '$shop_passwd'");
		if(!$num = pg_num_rows($r)){
			header("Location: ". _URL_ ."admin/login.php");
			exit;
		}else{
			$_SESSION['shop_name'] = pg_result($r,0,"shop_name");
	//		if(trim($_SESSION['shop_name']) == ''){
	//			header("Location: ". _URL_ ."admin/login.php");
	//			exit;
	//		}
		}
	}else{
		header("Location: ". _URL_ ."admin/login.php");

	}
}

/**
 * admin_check ()
 * アドミニストレータログインチェック
 * 戻り値 : なし
*/

function admin_check(){
	
	$admin_id       = $_SESSION['admin_id'];
	$admin_passwd   = $_SESSION['admin_passwd'];

	$r = execsql("select count(0) from m_admin where admin_id = '$admin_id' and admin_passwd = '$admin_passwd'");
	if(!pg_result($r,0,count)){
		header("Location: ". _URL_ ."admin/login.php");
		exit;
	}
}

function c_admin_check(){
	
	$c_admin_id       = $_SESSION['c_admin_id'];
	$c_admin_passwd   = $_SESSION['c_admin_passwd'];

	$r = execsql("select count(0) from m_c_admin where c_admin_id = '$c_admin_id' and c_admin_passwd = '$c_admin_passwd'");
	if(!pg_result($r,0,count)){
		header("Location: ". _URL_ ."admin/login.php");
		exit;
	}
}



/**
 * Add_where ($arg)
 * where文成形
 * 戻り値 : $W
*/

function Add_where($arg,$where) {
	global $W;
		if(!$where){
			$W .= " where ". $arg;
		}else{
			$W .= " and " . $arg;
		}
	return $W;
}

/**
 * Input_format ($arg)
 * 入力値成形
 * 戻り値 : $arg
*/

function Input_format($arg) {
//	$arg = mb_convert_kana($arg,"KHVn");// 半角カナ→全角変換 
//	$arg = htmlspecialchars($arg);
	$arg = pg_escape_string($arg);
//	$arg = trim($arg);
	return $arg;
}

/**
 * Input_format_html ($arg)
 * 入力値成形
 * html 有効
 * 戻り値 : $arg
*/

function Input_format_html($arg) {
//	$arg = mb_convert_kana($arg,"KHVn");// 半角カナ→全角変換 
	$arg = pg_escape_string($arg);
//	$arg = trim($arg);
	return $arg;
}

/**
 * Input_format_num ($arg)
 * 入力値成形
 * 数値判定
 * 戻り値 : $arg
*/

function Input_format_num($arg) {

	$arg = Input_format($arg);
	if(preg_match("/^[0-9]+$/", $arg)){ 
		return $arg;
	}else{
		return 0;
	}
}
function output_400_bad_request_error_page(){
    header("HTTP/1.1 400 Bad Request");
    echo <<< EOD
        <html lang="">

        <head>
           <title>400 Bad Request</title>
        </head>

        <body>
           <h1>Bad Request</h1>
           <p>Your browser sent a request that this server could not understand.<p>
        </body>

        </html>
EOD;
}
function output_404_not_found_error_page(){
    header("HTTP/1.1 404 Not Found");
    echo <<< EOD
        <html lang="">

        <head>
           <title>400 Not Found</title>
        </head>

        <body>
           <h1>Not Found</h1>
        </body>

        </html>
EOD;
}



?>