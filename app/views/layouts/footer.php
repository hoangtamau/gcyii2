<?php
$asset = app\assets\AppAsset::register($this);
?>

<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs footerborderright">
    <h4>Thẻ game</h4>
    <ul>
        <li><a  title=" " href="<?php echo SITE_PATH; ?>/the-appota-nap-game-gamota"  title=" " >Thẻ Appota</a></li>
        <li><a href="<?php echo SITE_PATH; ?>/gate-bac-gate-fpt.html"  title=" " >Thẻ Gate</a></li>
        <li><a href="<?php echo SITE_PATH; ?>/zing-card-zing-xu-vinagame.html"  title=" " >Thẻ Zing</a></li>
        <li><a href="<?php echo SITE_PATH; ?>/garena-nap-so.html"  title=" " >Thẻ Garena</a></li>
        <li><a href="<?php echo SITE_PATH; ?>/oncash-vdcnet2e-sgame.html">Thẻ Oncash</a></li>
    </ul>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs footerborderright">
    <h4>Thẻ điện thoại</h4>
    <ul class="footer_thephone">
        <li><a href="<?php echo SITE_PATH; ?>/the-viettel.html"  title=" " >Thẻ Viettel</a></li>
        <li><a href="<?php echo SITE_PATH; ?>/the-mobifone.html"  title=" " >Thẻ Mobi</a></li>
        <li><a href="<?php echo SITE_PATH; ?>/the-vinaphone.html"  title=" " >Thẻ Vina</a></li>
        <li>&nbsp;</li>
    </ul>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 footerborderright paddingmobii">
    <h4 class="hidden-xs">Hướng dẫn và hỗ trợ</h4>
    <h4 class="hidden-lg hidden-md hidden-sm">Hỗ trợ</h4>
    <p>US : 408-844-4577</p>
    <p>AU : 03-9005-5699</p>
    <p>VN : 028-62672181</p>
    <p class="hdht hidden-xs"><a href="<?php echo SITE_PATH; ?>/detail-news/huong-dan-thanh-toan-tai-viet-nam-316.html"  title=" " >Hướng dẫn thanh toán Việt Nam</a></p>
    <p class="hdht hidden-xs"><a href="<?php echo SITE_PATH; ?>/detail-news/huong-dan-thanh-toan-16.html"  title=" " >Hướng dẫn thanh toán quốc tế</a></p>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 paddingmobii">
    <h4>Mạng xã hội</h4>
    <div class="col-xs-12 footerface">		
        <a  target="_blank" href="https://www.facebook.com/gamecard.vn"  title=" " >
            <img  title="facebook" alt="facebook" src="<?php echo $asset->baseUrl; ?>/images/footerface.png" /> Facebook		
        </a>
    </div>
    <div class="col-xs-12 footergo">
        <img title="google" alt="google" src="<?php echo $asset->baseUrl; ?>/images/footergo.png" /> Google
    </div>
</div>
<div class="clearfix"></div>
<div class="hidden-lg hidden-md hidden-sm col-xs-12 footer-mobi" >
    <button class="buttonchatfooter"  type="button">Chat zalo: 0931.829.095</button>
    <a title="Chat on facebook" href="https://www.facebook.com/gamecard.vn" target="_blank">
        <button class="btn-mobi-chatonfacebook"  >Chat on facebook</button>
    </a>
    <a href="Skype:gamecardvn?chat" title="Chat skype" class="chat-skype-footer" >
        <button class="mobi-chat-skype"  type="button">Chat skype: gamecardvn</button>
    </a>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright copyright-footer"  >
    <?php if (Yii::$app->session->get('notation') == 'VND') { ?>
        <p>Công ty TMDT Việt Úc, Giấy phép KD: 0311869642</p>   
    <?php } else { ?>
        <p>Viet Aus Ecommerce Pty.Ltd, Australia _ ACN:168 741 973</p>
    <?php } ?>
</div>
