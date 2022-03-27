<?php

use yii\easyii\modules\news\api\Testm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\carousel\api\Carousel;
use yii\easyii\modules\article\models\Item;
use yii\easyii\helpers\Globals;

$asset = app\assets\AppAsset::register($this);
$session = Yii::$app->session;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi" xml:lang="vi" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
        <meta name="author" content="Game Card"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta charset="UTF-8"/>   
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>    
        <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon"/>
        
        
        <link href="<?php  echo ((Yii::$app->controller->id == "site") ? SITE_PATH :  SITE_PATH.Yii::$app->request->url) ?>" rel="canonical" />
        <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon"/>
        <?php $this->head() ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-50923353-1', 'auto');
            ga('send', 'pageview');

        </script>
        <script type="application/ld+json">
            {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Gamecard",
            "url": "https://gamecard.vn/",
            "sameAs": [
                "https://plus.google.com/u/0/+GamecardVn-the-game",
                "https://www.facebook.com/gamecard.vn/"
                ]
            }
        </script>
    </head>    
    <body style="position: relative;">
		<!--<img style="position: absolute; left:0px; top:0px;" class="hidden-xs app-android-hide" src="<?php echo SITE_PATH; ?>/uploads/tet2018/1.png" title="Quà tặng trung thu" alt="Quà tặng trung thu" />
		<img style="position: absolute; right:0px; top:0px;" class="hidden-xs app-android-hide" src="<?php echo SITE_PATH; ?>/uploads/tet2018/2.png" title="Quà tặng trung thu" alt="Quà tặng trung thu" />
		<!-- Load Facebook SDK for JavaScript -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<!-- Your customer chat code -->
		<div class="fb-customerchat"
		  attribution=setup_tool
		  page_id="651423054888790">
		</div>
        <?php $this->beginBody() ?>
        <div class="container header clearfix paddingleftright" style="position: relative;">			
            <div class="col-lg-12 col-md-12 hidden-sm hidden-xs">

                <?php if (Yii::$app->controller->id == "site") { ?>
                    <h1 class="mainhone">Mua thẻ game online cho game thủ Việt sống ở nước ngoài</h1>
                <?php } else { ?>		
                    <div class="maindivhead">
                        Mua thẻ game online cho game thủ Việt sống ở nước ngoài
                    </div>
                <?php } ?>
            </div>
            <?php $this->beginContent('@app/views/layouts/header_hhhh.php'); ?><?php $this->endContent(); ?>    
        </div>
	
        <?php $this->beginContent('@app/views/layouts/menu.php'); ?><?php $this->endContent(); ?>
		
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-web paddingleftright" >            

            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 leftweb">
                <?php $this->beginContent('@app/views/layouts/left.php'); ?><?php $this->endContent(); ?>
            </div>

            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 paddingleftright rightcontent">	

                <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs paddingleftright ful-slide-show">			
                    <div class="col-lg-8 col-md-8 col-sm-7 slideshow hidden-xs" >
                        <?= Carousel::widget(1140, 520) ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-5 newpromotion hidden-xs paddingleftright divkhuyenmai">
                        <h3 class="tinkhuyenmai"><img  title="Tin khuyến mãi" alt="Tin khuyến mãi" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />Tin khuyến mãi</h3>
                        <ul>
                            <?php
                            $listitem = Item::getListkhuyenmai();
                            foreach ($listitem as $r) {
                                ?>
                                <li> - <a href="<?php echo SITE_PATH ?>/detail-news/<?php echo $r->slug; ?>" title="<?php echo $r->title ?>"><?php echo $r->title; ?></a></li>                        
                            <?php } ?>                    
                        </ul>
                        <p><a class="morekm" href="<?php echo SITE_PATH ?>/khuyen-mai.html" title="Xem thêm">>> Xem thêm</a></p>
                    </div>
                </div>
                <div class="clearfix"></div>

                <?php if (Yii::$app->session->hasFlash('Register-success')) { ?>
                    <?php echo "<p class='alert' >" . Yii::$app->session->getFlash("Register-success") . "</p>"; ?>
                <?php } ?>		
                <?php if (Yii::$app->session->hasFlash('success')) { ?>            
                    <?php echo "<p class='alert' >" . Yii::$app->session->getFlash("success") . "</p>"; ?>
                <?php } ?>
                <?php if (Yii::$app->session->hasFlash('menhgia')) { ?>            
                    <?php echo "<p class='alert' " . Yii::$app->session->getFlash("menhgia") . "</p>"; ?>
                <?php } ?>
                <?php if (Yii::$app->session->hasFlash('falseloginsocial')) { ?>            
                    <?php echo "<p class='alert' >" . Yii::$app->session->getFlash("falseloginsocial") . ". Vui lòng sử dụng chức năng <a href='https://gamecard.vn/forgot-password.html'>Quên mật khẩu</a> để cài đặt mật khẩu mới. Cảm ơn</p>"; ?>
                <?php } ?>
                <?= $content ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="footer" style="position: relative;">
			
            <div class="container">
                <?php $this->beginContent('@app/views/layouts/footer.php'); ?><?php $this->endContent(); ?>
            </div>
        </div>
        <div class="clearfix"></div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>