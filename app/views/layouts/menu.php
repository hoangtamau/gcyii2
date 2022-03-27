<?php

use yii\easyii\modules\article\api\Article;

$asset = app\assets\AppAsset::register($this);
$arti = 0;
if (Yii::$app->controller->id == "articles") {
    $slug = $_GET['slug'];
    $article = Article::get($slug);
    $arti = $article->category_id;
}
?>

<div class="navigation-menu clearfix">
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse-right">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="hidden-lg hidden-md hidden-sm navbar-brand">       
                    <div >Menu</div>
                </div>
            </div>
            <div class="navbar-collapse navbar-collapse-right collapse">
                <ul class="nav navbar-nav">
                    <li class="level0">
                        <a href="<?php echo SITE_PATH ?>" title="Trang chủ">
                            <span>Trang chủ</span>
                        </a>
                    </li>
                    <li class="level0">
                        <a href="<?php echo SITE_PATH ?>/tai-khoan.html" title="Tài khoản">
                            <span>Tài khoản</span>
                        </a>
                    </li>
                    <li class="level0">
                        <a href="<?php echo SITE_PATH ?>/tin-tuc.html" title="Tin tức">
                            <span>Tin tức </span>
                        </a>
                    </li>
                    <li class="level0">
                        <a href="<?php echo SITE_PATH ?>/huong-dan.html" title="Hướng dẫn">
                            <span>Hướng dẫn </span>
                        </a>
                    </li>
                    <li class="level0">
                        <a href="<?php echo SITE_PATH ?>/lien-he.html" title="Liên hệ">
                            <span>Liên hệ </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-12 main-web paddingleftright menu_main-web" >
    <div class="menu-left" >
        &nbsp;
    </div>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 leftweb menuleft paddingleftright" >        
        <div class="menucenter1">
            <a title="Gamecard" href="<?php echo SITE_PATH; ?>">
                <img alt="Gamecard.vn" title="GamecardVN" src="<?php echo $asset->baseUrl; ?>/images/menucenter1.png" />
            </a>
        </div>
    </div>
    <div  class="col-lg-9 col-md-8 col-sm-8 col-xs-8 paddingleftright rightcontent menurightcontent">
        <div class="menucenter_right1">
            <ul >
                <li <?php if (Yii::$app->controller->id == "site" || Yii::$app->controller->id == "") { ?> class="active" <?php } ?>><a class="trangchu"  href="<?php echo SITE_PATH ?>" title="Trang chủ"><span>Trang chủ </span></a></li>
                <li <?php if (Yii::$app->controller->id == "default") { ?> class="active" <?php } ?>><a href="<?php echo SITE_PATH ?>/tai-khoan.html" title="Tài khoản"><span>Tài khoản </span></a></li>
                <li <?php if (Yii::$app->controller->id == "tintuc" || $arti == 9) { ?> class="active" <?php } ?>><a href="<?php echo SITE_PATH ?>/tin-tuc.html" title="Tin tức"><span>Tin tức </span></a></li>
                <li <?php if (Yii::$app->controller->id == "huongdan" || $arti == 5) { ?> class="active" <?php } ?>><a href="<?php echo SITE_PATH ?>/huong-dan.html" title="Hướng dẫn"><span>Hướng dẫn </span></a></li>
                <li <?php if (Yii::$app->controller->id == "lienhe") { ?> class="active" <?php } ?>><a href="<?php echo SITE_PATH ?>/lien-he.html" title="Liên hệ"><span>Liên hệ </span></a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>

	<div class="chplay">
		<a target="_blank" title="GamecardVN - Download App on Goolge Play Store" href="https://play.google.com/store/apps/details?id=vaeapp.gamecard.vn">
			<img alt="GamecardVN - Download App on Goolge Play Store" src="<?php echo $asset->baseUrl; ?>/images/googlechplay.png" />
		</a>
	</div>
	
    <div class="social" >
        <div id="fb-root"></div>
       
        <script>
			(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=773903549347868";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class="facebook item" >
            <div class="fb-share-button" data-href="http://gamecard.vn/" data-layout="button_count"></div>
        </div>
        <div class="twitter item">        
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="https://twitter.com/gamecard" data-counturl="http://groups.google.com/group/twitter-api-announce" data-lang="en" data-count="vertical">Tweet</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");</script>
        </div> 
        <div class="google item" >
            <script  src="https://apis.google.com/js/platform.js"></script>
            <div class="g-plusone" data-size="medium" data-href="https://gamecard.vn?v2"></div>	 
        </div>
    </div>
    <div class="clearfix"></div>
</div>