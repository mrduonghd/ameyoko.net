<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/contact/contact.class.php");
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
    <title>アメ横へのお問い合わせ｜上野アメ横商店街公式サイト</title>

    <!-- Social Share - Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:url" content="https://www.ameyoko.net/contact/">
    <meta property="og:image" content="https://www.ameyoko.net/shared/img/shared/ogp.png">
    <meta property="og:title" content="アメ横へのお問い合わせ｜上野アメ横商店街公式サイト">
    <meta property="og:site_name" content="アメ横へのお問い合わせ｜上野アメ横商店街公式サイト">
    <meta property="og:description" content="お問い合わせはこちらから。">
    <meta property="fb:app_id" content="3879227578969131">

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
    <link rel="canonical" href="https://www.ameyoko.net/contact/">
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
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/shared/header.html"); ?>
    </header>
    <div class="key-shared">
        <h2 class="wow fadeInUp"><span class="tt"><span class="f_cl">アメ横</span>へのお問い合わせ</span></h2>
    </div>
    <section class="nav-target">
        <div id="contact">
            <div class="wrap wow fadeInUp">
                <p class="note">商品等に関するお問い合わせは、各店舗にお問い合わせをお願いいたします。 </p>
                <form class="form" action="/contact/check.php"  method="POST">
                    <div class="contact_form">
                        <dl>
                            <dt>お名前<span class="req">必須</span>
                                <span class="error"><?php if( isset($_SESSION['contact-name-error']) ){ echo htmlspecialchars($_SESSION['contact-name-error']); } ?></span></dt>
                            <dd>
                                <input type="text" name="contact-name" value="<?php if( isset($_SESSION['contact-name'] ) ){ echo htmlspecialchars($_SESSION['contact-name']); } ?>">
                            </dd>
                        </dl>
                        <dl>
                            <dt>メールアドレス<span class="req">必須</span>
                                <span class="error"><?php if( isset($_SESSION['contact-email-error']) ){ echo htmlspecialchars($_SESSION['contact-email-error']); } ?></span></dt>
                            <dd>
                                <input type="email" name="contact-email" value="<?php if( isset( $_SESSION['contact-email'] ) ){ echo htmlspecialchars($_SESSION['contact-email']); } ?>">
                            </dd>
                        </dl>
                        <dl>
                            <dt>お問い合わせ内容<span class="req">必須</span>
                                <span class="error"><?php if( isset($_SESSION['contact-message-error']) ){ echo htmlspecialchars($_SESSION['contact-message-error'] ) ; } ?></span></dt>
                            <dd>
                                <textarea name="contact-message" cols="50" rows="5"><?php if( isset($_SESSION['contact-message'] ) ){ echo htmlspecialchars($_SESSION['contact-message']); } ?></textarea>
                            </dd>
                        </dl>
                        <p class="check">
                            <label >
                                <input type="checkbox" id="confirmation" name="rule" <?php if(isset($_SESSION['check-box'])) echo 'checked'  ?> value="個人情報の取り扱いについて同意します" />
                                <span class="checkmark"></span>個人情報の取り扱いについて同意します</label>
                        </p>
                        <div class="bnr wow fadeInUp">
                            <input type="submit" id="submit" disabled name="submit" value="入力内容の確認へ" class="btn-submit"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="breadcrumb">
        <div class="wrap">
            <ul>
                <li><a href="index.php">ホーム</a></li>
                <li>お問い合わせ</li>
            </ul>
        </div>
    </div>
    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/shared/footer.html"); ?>
    </footer>
    <!-- Scroll to top -->
    <p id="pagetop"><img src="../shared/img/shared/up.png" alt="最上部へ" width="160" height="160" class="pc"><img src="../shared/img/shared/up_sp.svg" alt="最上部へ" width="160" height="160" class="sp">
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
