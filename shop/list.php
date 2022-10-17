<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/shop/list_inc.php");
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
    <title>��Ź��õ���þ���Უ��Ź������������</title>

    <!-- Social Share - Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:url" content="https://www.ameyoko.net/shop/list.php?category=<?php echo $_GET['category'];?>&online=<?php echo $_GET['online'];?>">
    <meta property="og:image" content="https://www.ameyoko.net/shared/img/shared/ogp.png">
    <meta property="og:title" content="��Ź��õ���þ���Უ��Ź������������">
    <meta property="og:site_name" content="��Ź��õ���þ���Უ��Ź������������">
    <meta property="og:description" content="����Უ��Ź����Ź�ް����Ǥ���">
    <meta property="fb:app_id" content="3879227578969131">

    <!-- SEO -->
    <meta name="keywords" content="����,���Უ,��Ź��,���,�����,�����ۡ���ڡ���,AMEYOKO,UENO">
    <meta name="description" content="����Უ��Ź����Ź�ް����Ǥ���">

    <!-- Mobile -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, shrink-to-fit=no">
    <!-- Profiles -->
    <link rel="canonical" href="https://www.ameyoko.net/shop/list.php?category=<?php echo $_GET['category'];?>&online=<?php echo $_GET['online'];?>">
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
    <link rel="stylesheet" href="../shared/css/global.css?v=2022032401">
    <!-- Global site tag (gtag.js) - Google Analytics -->
</head>
<body>
<main>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/shared/header_euc.html"); ?>
    </header>
    <section class="nav-target">
        <div id="shop" class="shoplist_shared">
            <div class="header_top">
                <div class="wrap">
                    <ul class="link d_flex">
                        <li <?php if($online == 'no' or $online == ''){ echo 'class="active"'; } ?> ><a href="/shop/list.php?category=all&online=no" class="ico1">��Ź��õ��</a></li>
                        <li <?php if($online == 'yes'){ echo 'class="active"'; } ?> ><a href="/shop/list.php?category=all&online=yes" class="ico2">����饤��<br class="sp">����åԥ�</a></li>

                    </ul>
                    <ul class="cate d_flex">
                        <li <?php if( $category == 'all'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=all&online=<?php echo $online; ?> "><img src="../shared/img/shop/tab1.png" width="200" height="200" alt="���٤�"/><img src="../shared/img/shop/tab1_on.png" width="200" height="200" alt="���٤�" class="on"/><span>���٤�</span></a></li>
                        <li <?php if( $category == 'fashion'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=fashion&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab2.png" width="200" height="200" alt="�ե��å����"/><img src="../shared/img/shop/tab2_on.png" width="200" height="200" alt="�ե��å����" class="on"/><span>�ե��å����</span></a></li>
                        <li <?php if( $category == 'shoes_bag_accessorie'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=shoes_bag_accessorie&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab3.png" width="200" height="200" alt="�����Хå�����ʪ"/><img src="../shared/img/shop/tab3_on.png" width="200" height="200" alt="�����Хå�����ʪ" class="on"/><span>�����Хå�����ʪ</span></a></li>
                        <li <?php if( $category == 'gourmet'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=gourmet&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab4.png" width="200" height="200" alt="�����"/><img src="../shared/img/shop/tab4_on.png" width="200" height="200" alt="�����" class="on"/><span>�����</span></a></li>
                        <li <?php if( $category == 'food'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=food&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab5.png" width="200" height="200" alt="����"/><img src="../shared/img/shop/tab5_on.png" width="200" height="200" alt="����" class="on"/><span>����</span></a></li>
                        <li <?php if( $category == 'sundry_goods'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=sundry_goods&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab6.png" width="200" height="200" alt="����"/><img src="../shared/img/shop/tab6_on.png" width="200" height="200" alt="����" class="on"/><span>����</span></a></li>
                        <li <?php if( $category == 'cosme_drag'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=cosme_drag&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab7.png" width="200" height="200" alt="�����ᡦ��"/><img src="../shared/img/shop/tab7_on.png" width="200" height="200" alt="�����ᡦ��" class="on"/><span>�����ᡦ��</span></a></li>
                        <li <?php if( $category == 'leisure_other'){echo 'class="active"'; } ?>><a href="/shop/list.php?category=leisure_other&online=<?php echo $online; ?>"><img src="../shared/img/shop/tab8.png" width="200" height="200" alt="�쥸�㡼������¾"/><img src="../shared/img/shop/tab8_on.png" width="200" height="200" alt="�쥸�㡼������¾" class="on"/><span>�쥸�㡼������¾</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="wrap">
                <div class="blog">
                    <div class="row d_flex">
                        <?php $count = 0;
                        foreach ($shop_list as $shop) {
                            $shop_data = explode("\n", $shop['shop_data']);
                            $tel = $shop_data[0];
                            $business_hours = $shop_data[1];
                            $regular_holiday = $shop_data[2];
                            $count++;
                            ?>
                            <div class="item">
                                <p class="photo"><a href="<?php if($_GET['online'] == 'yes'){ echo $shop['url']; }else{ echo '/shop/'. $shop['shop_no'];} ?>"><img <?php if($count <= 4){ echo 'src=';}else{echo 'data-src=';}?>"<?php if($_GET['online'] == 'yes'){ echo file_exists($shop['logo_image']) ? $shop['logo_image'] :  "./shop_images/no_image_thumb.gif"; }else{ echo file_exists("./shop_images/". $shop['shop_no']. "/1.jpg") ? "./shop_images/". $shop['shop_no']. "/1.jpg" : "./shop_images/no_image_thumb.gif";} ?>" width="510" height="510" alt="<?php echo htmlspecialchars($shop['shop_name']); ?>" class="object-fit-cover<?php if($count > 4){echo ' lazyload';} ?>"/></a></p>
                                <dl>
                                    <dt><a href="<?php if($_GET['online'] == 'yes'){ echo $shop['url']; }else{ echo '/shop/'. $shop['shop_no'];} ?>"><?php echo htmlspecialchars($shop['shop_name']); ?></a></dt>
                                    <?php if ($online == 'yes') { ?>
                                        <?php echo Shop::ret_shop_category_name($shop['category']); ?>
                                    <?php }else{ ?>
                                        <dd>Tel��<a href="tel:<?php echo htmlspecialchars(str_replace('-', '', $tel)); ?>"><?php echo htmlspecialchars($tel); ?></a><br>
                                            �ĶȻ��֡�<?php echo htmlspecialchars($business_hours); ?><br>
                                            �������<?php echo htmlspecialchars($regular_holiday); ?></dd>
                                    <?php }?>
                                </dl>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="breadcrumb">
        <div class="wrap">
            <ul>
                <li><a href="list.php">�ۡ���</a></li>
                <li><a href="/shop/list.php?category=all&online=<?php echo $online;?>"><?php if($online == 'yes'){echo '�����饤�󥷥�åԥ�';}else{echo '��Ź��õ��';}?></a></li>
                <li><?php echo Shop::ret_shop_category_name($_GET['category']); ?></li>
            </ul>
        </div>
    </div>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/shared/footer_euc.html"); ?>
    </footer>
    <!-- Scroll to top -->
    <p id="pagetop"><img src="../shared/img/shared/up.png" alt="�Ǿ�����" width="160" height="160" class="pc"><img src="../shared/img/shared/up_sp.svg" alt="�Ǿ�����" width="160" height="160" class="sp">
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
<script src="./assets/js/lazyload.min.js"></script>
<script>lazyload();</script>
</body>
</html>
