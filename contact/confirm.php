<?php
  session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" lang="ja"><![endif]-->
<!--[if IE 7]><html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" lang="ja"><![endif]-->
<!--[if IE 8]><html class="ie ie8 ie-lt10 ie-lt9 no-js" lang="ja"><![endif]-->
<!--[if IE 9]><html class="ie ie9 ie-lt10 no-js" lang="ja"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="ja">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Ameyokonet">
    <title>お問い合わせ内容の確認｜上野アメ横商店街公式サイト</title>

    <!-- Social Share - Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:url" content="https://www.ameyoko.net/contact/confirm.html">
    <meta property="og:image" content="https://www.ameyoko.net/shared/img/shared/ogp.png">
    <meta property="og:title" content="お問い合わせ内容の確認｜上野アメ横商店街公式サイト">
    <meta property="og:site_name" content="お問い合わせ内容の確認｜上野アメ横商店街公式サイト">
    <meta property="og:description" content="お問い合わせはこちらから。">
    <meta property="fb:app_id" content="3879227578969131eck">

    <!-- SEO -->
    <meta name="keywords" content="上野,アメ横,商店街,東京,台東区,公式ホームページ,AMEYOKO,UENO">
    <meta name="description" content="お問い合わせはこちらから。">

    <!-- Mobile -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <!-- Profiles -->
    <link rel="canonical" href="https://www.ameyoko.net/contact/confirm.html">
    <link rel="profile" href="http://microformats.org/profile/hcard">
    <link rel="apple-touch-icon" href="shared/img/shared/apple-icon.png">
    <link rel="shortcut icon" href="shared/img/shared/favicon.ico">
    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../shared/css/common.css">
    <link rel="stylesheet" href="../shared/css/shared.css">
    <link rel="stylesheet" href="../shared/css/animate.min.css">
    <link rel="stylesheet" href="../shared/css/global.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
</head>
<body>
<main>
    <header>
        <div class="hamburger"><span></span> <span></span> <span></span></div>
        <div id="belt" class="nav-fixed">
            <div class="wrap">
                <h1><a href="../"><img src="../shared/img/shared/logo.svg" alt="アメ横"><span>アメ横公式サイト</span></a></h1>
            </div>
            <div id="navigation">
                <ul>
                    <li class="sub_logo"><a href="../"><img src="../shared/img/shared/f_logo.svg" alt="アメ横"><span>アメ横公式サイト</span></a></li>
                    <li><a href="../"><img src="../shared/img/shared/ico1.svg" alt="ホーム"/>ホーム</a></li>
                    <li><a href="../shop"><img src="../shared/img/shared/ico2.svg" alt="お店を探す"/>お店を探す</a></li>
                    <li class="sub"><a href="#"><img src="../shared/img/shared/ico3.svg" alt="オンラインショッピング"/>オンラインショッピング</a>
                        <ul>
                            <li><a href="#">カートをみる</a></li>
                            <li><a href="#">店舗一覧 </a></li>
                            <li><a href="#">利用ガイド </a></li>
                            <li><a href="#">アカウント/ログイン </a></li>
                            <li><a href="#">お気に入り</a></li>
                        </ul>
                    </li>
                    <li><a href="../access"><img src="../shared/img/shared/ico4.svg" alt="アクセス" class="map"/>アクセス</a></li>
                    <li><a href="../map"><img src="../shared/img/shared/ico5.svg" alt="アメ横マップ"/>アメ横マップ</a></li>
                    <li class="soc d_flex"><a href="#" target="_blank"><img src="../shared/img/shared/sub_soc1.png" width="120" height="120" alt="instagram"/></a><a href="#" target="_blank"><img src="../shared/img/shared/sub_soc2.png" width="120" height="120" alt="twitter"/></a><a href="#" target="_blank"><img src="../shared/img/shared/sub_soc3.png" width="120" height="120" alt="facebook"/></a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="key-shared">
        <h2 class="wow fadeInUp"><span class="tt"><span class="f_cl">アメ横</span>へのお問い合わせ</span></h2>
    </div>
    <section class="nav-target">
        <div id="contact">
            <div class="wrap wow fadeInUp">
                <div class="confirm">
                    <p class="f_note txt-center">まだ送信は完了していません。<br>
                        以下内容でよろしければ、この画面下部の<br class="ipad_view">「送信する」ボタンを押してください。</p>
                    <form class="form" action="/contact/send.php"  method="POST">
                        <div class="confirm_info">
                            <dl>
                                <dt>お名前</dt>
                                <dd><?php if( isset($_SESSION['contact-name'] ) ){ echo htmlspecialchars( $_SESSION['contact-name']); } ?></dd>
                            </dl>
                            <dl>
                                <dt>メールアドレス</dt>
                                <dd><?php if( isset($_SESSION['contact-email'] ) ){ echo htmlspecialchars($_SESSION['contact-email']); } ?></dd>
                            </dl>
                            <dl>
                                <dt>お問い合わせ内容</dt>
                                <dd><?php if( isset($_SESSION['contact-message'] ) ){ echo nl2br(htmlspecialchars($_SESSION['contact-message'])); } ?></dd>
                            </dl>
                        </div>
                        <ul class="bnr-form d_flex">
                            <li class="bnr back">
                                <input type="button" name="back" value="修正する" class="btn-back" onclick="location.href='/contact/index.php'"/>
                            </li>
                            <li class="bnr">
                                <input type="submit" name="submit" value="送信する" class="btn-submit"/>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="breadcrumb">
        <div class="wrap">
            <ul>
                <li><a href="./../index.php">ホーム</a></li>
                <li><a href="../contact">お問い合わせ</a></li>
                <li>お問い合わせ内容の確認</li>
            </ul>
        </div>
    </div>
    <footer>
        <div class="wrap">
            <div class="group d_flex">
                <div class="shop">
                    <p class="logo"><a href="../"><img src="../shared/img/shared/f_logo.svg" alt="アメ横"><br>
                            <span>アメ横公式サイト</span></a></p>
                    <p class="link"><a href="https://www.ameyoko.net/info/ameyoko_Coverage.pdf" target="_blank">メディア様向け取材申し込み用紙は<br>
                            こちらよりダウンロードできます。</a></p>
                    <nav> <a href="../">ホーム</a><a href="../shop">お店を探す</a><a href="">オンラインショッピング</a><a href="../access">アクセス</a><a href="../map">アメ横マップ</a><a href="../contact">お問い合わせ</a><a href="http://www.ameyokonet.jp/" target="_blank">運営会社</a><a href="https://www.ameyoko.net/terms/" target="_blank">利用規約</a><a href="https://www.ameyoko.net/privacy/" target="_blank">プライバシーポリシー</a></nav>
                </div>
                <div class="card">
                    <dl>
                        <dt class="ext">アメ横商店連合会</dt>
                        <dd>〒110-0005 東京都台東区上野6-10-7 アメ横プラザ内<br>
                            <a href="tel:0338325053">03-3832-5053</a> / <a href="tel:0338373619">03-3837-3619</a></dd>
                    </dl>
                    <dl>
                        <dt>運営会社 </dt>
                        <dd><span>アメヨコネット株式会社</span><br>
                            〒110-0005 東京都台東区上野6-4-6 <a href="http://www.ameyokonet.jp/" target="_blank" class="bnr"><img src="../shared/img/shared/f_bnr1.jpg" width="140" height="32" alt="アメヨコネット株式会社"/></a></dd>
                    </dl>
                    <dl>
                        <dt>関連サイト</dt>
                        <dd>
                            <ul class="d_flex">
                                <li><a href="https://uenogasuki.tokyo/" target="_blank"><img src="../shared/img/shared/f_bnr2.jpg" width="109" height="44" alt="uenogasuki"/></a></li>
                                <li><a href="https://t-navi.city.taito.lg.jp/" target="_blank"><img src="../shared/img/shared/f_bnr3.jpg" width="160" height="44" alt="taitonavi"/></a></li>
                                <li><a href="http://www.guidenet.jp/" target="_blank"><img src="../shared/img/shared/f_bnr4.jpg" width="88" height="44" alt="guidenet"/></a></li>
                                <li><a href="https://welmopanda.jimdofree.com/" target="_blank"><img src="../shared/img/shared/f_bnr5.jpg" width="44" height="44" alt="welmopanda"/></a></li>
                            </ul>
                        </dd>
                    </dl>
                </div>
            </div>
            <address>
                &copy; 2000-2022 AmeyokoNet
            </address>
        </div>
    </footer>
    <!-- Scroll to top -->
    <p id="pagetop"><img src="../shared/img/shared/up.png" alt="最上部へ" width="160" height="160" class="pc"><img src="../shared/img/shared/up_sp.svg" alt="最上部へ" width="160" height="160" class="sp"> </p>
</main>
<!-- Facebook - Social -->
<div id="fb-root"></div>

<!-- Libraries script -->
<script src="../shared/js/base.js"></script>
<script src="../shared/js/autoload.js"></script>
<script src="../shared/js/jquery.min.js"></script>
<script src="../shared/js/common.js"></script>
<script src="../shared/js/shared.js"></script>
</body>
</html>
