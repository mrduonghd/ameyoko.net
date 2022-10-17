<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/shop/detail_inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/Config.php");
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
    <meta charset="EUC-JP">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Ameyokonet">
    <title><?php echo htmlspecialchars($shop_data[0]['shop_name']) ;?>｜上野アメ横商店街公式サイト</title>

    <!-- Social Share - Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:url" content="https://www.ameyoko.net/shop/<?php echo $_GET['shop_no'];?>">
    <meta property="og:image" content="https://www.ameyoko.net/shared/img/shared/ogp.png">
    <meta property="og:title" content="<?php echo htmlspecialchars($shop_data[0]['shop_name']);?>｜上野アメ横商店街公式サイト">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($shop_data[0]['shop_name']);?>｜上野アメ横商店街公式サイト">
    <meta property="og:description" content="<?php echo htmlspecialchars($shop_data[0]['shop_name']);?>の店舗詳細です。">
    <meta property="fb:app_id" content="3879227578969131">

    <!-- SEO -->
    <meta name="keywords" content="上野,アメ横,商店街,東京,台東区,公式ホームページ,AMEYOKO,UENO">
    <meta name="description" content="<?php echo htmlspecialchars($shop_data[0]['shop_name']);?>の店舗詳細です。">

    <!-- Mobile -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, shrink-to-fit=no">
    <!-- Profiles -->
    <link rel="canonical" href="https://www.ameyoko.net/shop/<?php echo $_GET['shop_no'];?>">
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
    <link rel="stylesheet" href="../shared/css/global.css?v=2022031801">
    <!-- Global site tag (gtag.js) - Google Analytics -->
</head>
<body>
<main>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/shared/header_euc.html"); ?>
    </header>
    <div class="key-shared">
        <h2 class="wow fadeInUp"><span class="tt"><?php echo htmlspecialchars($shop_data[0]['shop_name']); ?></span></h2>
    </div>
    <section class="nav-target">
        <div id="shop_details">
            <div class="wrap">
                <div class="lead d_flex">
                    <div class="photo wow fadeInUp"><img src="<?php echo file_exists("./shop_images/". $shop_data[0]['shop_no']. "/1.jpg") ? "./shop_images/". $shop_data[0]['shop_no']. "/1.jpg" : "./shop_images/no_image.gif"; ?>" width="540" height="389" alt="<?php echo htmlspecialchars($shop_data[0]['shop_name']); ?>"/></div>
                    <div class="tbl_info wow fadeInUp">
                        <dl>
                            <dt>住所</dt>
                            <dd><?php echo htmlspecialchars($shop_data[0]['address']); ?></dd>
                        </dl>
                        <dl>
                            <dt>電話番号</dt>
                            <dd><a href="tel:<?php echo htmlspecialchars(str_replace('-', '', $shop_data[0]['tel'])); ?>"><?php echo htmlspecialchars($shop_data[0]['tel']); ?></a></dd>
                        </dl>
                        <dl>
                            <dt>営業時間</dt>
                            <dd><?php echo htmlspecialchars($shop_data[0]['business_hours']); ?></dd>
                        </dl>
                        <dl>
                            <dt>定休日</dt>
                            <dd><?php echo htmlspecialchars($shop_data[0]['regular_holiday']); ?></dd>
                        </dl>
                        <?php if($shop_data[0]['url']){ ?>
                            <dl>
                                <dt>ホームページ</dt>
                                <dd><a href="<?php echo htmlspecialchars($shop_data[0]['url']); ?>" target="_blank"><?php echo htmlspecialchars($shop_data[0]['url']); ?></a></dd>
                            </dl>
                        <?php } ?>
                        <?php if($shop_data[0]['email']){ ?>
                            <dl>
                                <dt>メールアドレス</dt>
                                <dd><a href="mailto:<?php echo htmlspecialchars($shop_data[0]['email']); ?>"><?php echo htmlspecialchars($shop_data[0]['email']); ?></a></dd>
                            </dl>
                        <?php } ?>
                        <dl>
                            <dt>販売責任者</dt>
                            <dd><?php echo htmlspecialchars($shop_data[0]['charge']); ?></dd>
                        </dl>
                    </div>
                </div>
                <?php if($mp_shop_data){ ?>
                    <p class="bnr wow fadeInUp"><a href="<?php echo htmlspecialchars($mp_shop_data['url']) ?>" target="_blank"><img src="../shared/img/shop/ico3.svg" alt="このお店の商品を見る"/>このお店の商品を見る</a></p>
                <?php } ?>
                <div class="info wow fadeInUp">
                    <?php echo $shop_data[0]['comment']; ?>
                </div>
                <?php
                $google_map_url = Shop::ret_google_map_url($shop_data[0]['shop_no']);
                if($google_map_url){
                    ?>
                    <div class="g_map wow fadeInUp">
                        <iframe src="<?php echo $google_map_url; ?>" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <div class="breadcrumb">
        <div class="wrap">
            <ul>
                <li><a href="list.php">ホーム</a></li>
                <li><a href="/shop/list.php?category=all&online=no">お店を探す</a></li>
                <li><?php echo htmlspecialchars($shop_data[0]['shop_name']); ?></li>
            </ul>
        </div>
    </div>
    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/shared/footer_euc.html"); ?>
    </footer>
    <!-- Scroll to top -->
    <p id="pagetop">
        <picture>
            <source media="(max-width:767px)" srcset="shared/img/shared/up_sp.svg">
            <img src="../shared/img/shared/up.png" alt="最上部へ" width="160" height="160">
        </picture>
    </p>
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
