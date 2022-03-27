<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\modules\page\api\Page;
use yii\easyii\modules\catalog\api\Catalog;

use app\models\AddToCartForm;
use yii\widgets\ActiveForm;

$page = Page::get('page-contact');
$this->title = "Liên hệ";
$this->params['breadcrumbs'][] = $page->model->title;
$asset= app\assets\AppAsset::register($this);

use amnah\yii2\user\models\Countries;
use yii\web\Session;
$session = Yii::$app->session;
$country = $session->get('country');		
$countryname=  Countries::find()->where('country_iso_code_2 = "'.$country->countryCode.'"')->one();	 
           //echo $country->city;
           //echo $country->postalCode;
           //echo $countryname['country_name'];
		   
		   //echo Yii::getVersion();

?>
<style>
    .item1 a{ text-decoration: none; margin: 0px 5px;}
    .item1 a:hover{ text-decoration: underline;}
</style>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
    Liên hệ
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <div class="info_company">    
        <div class="item1" style="padding-bottom:7px;">
            <span class='tencty' style="font-size: 20px;font-weight: bold;"><a style="color: #4d87c7;" href="<?php echo SITE_PATH;?>" target="_blank">GameCard.VN a product of VAE group</a></span></div>
        <div class="item1" style="padding-bottom:7px;">
            <p style="margin-bottom:5px;">Specialist distributor</p>
            <a href='<?=SITE_PATH?>/the-game-online'>Game card online</a>  | <a href='<?=SITE_PATH?>/the-megacard-vnpt-epay'>Thẻ Megacard</a>  | <a href='<?=SITE_PATH?>/the-appota-nap-game-gamota'>Thẻ Appota</a>  | <a href='<?=SITE_PATH?>/qpal-the-bit.html'>Thẻ Bit</a> | <a href='<?=SITE_PATH?>/zing-card-zing-xu-vinagame.html'>Zing xu</a> | <a href='<?=SITE_PATH?>/gate-bac-gate-fpt.html'>Gate</a> | <a href='<?=SITE_PATH?>/garena-nap-so.html'>Garena</a> | <a href='http://gamecard.vn/qpal-the-bit.html'>thẻ bit- Qpal</a> | <a href='http://gamecard.vn/oncash-vdcnet2e-sgame.html'>Oncash</a> | <a href='http://gamecard.vn/vcoin-vn.html'>Vcoin</a><br>
            <a href='<?=SITE_PATH?>/the-mobifone.html'>Mobiphone Card</a> | <a href='<?=SITE_PATH?>/the-viettel.html'>Viettel Card</a> | <a href='<?=SITE_PATH?>/the-vinaphone.html'>VinaPhone Card</a>
        </div>
        <div class="item1" style="padding-bottom:7px;">
            <div class=' ym-gl'>Hotline:</div>
            <div class="ym-gl hotline_contact"> USA:<span>1-408-844-4599</span> - AUS: <span>61-03-9005-5699</span> - VN: <span> 84-028-62672181</span></div>						
        </div>
        <div class="item1" style="padding-bottom:7px;">							

        <p style="padding-bottom:3px;">
            <span style="font-weight:bold;">Hỗ trợ mua hàng : </span>vngamecard (Yahoo)
            <!--<a href="ymsgr:sendim?vngamecard" mce_href="ymsgr:sendim?vngamecard" border="0">
			<img style="vertical-align:middle;" src="http://opi.yahoo.com/online?u=vngamecard&t=1" mce_src="http://opi.yahoo.com/online?u=vngamecard&t=1"></a>-->
        </p>
        <p style="padding-bottom:3px;">
			<span style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Skype : </span>
			<a href="skype:gamecardvn?call">
				<img border="0" src="<?php echo $asset->baseUrl;?>/images/skype.png" />
			</a>
        </p>
        <p style="padding-bottom:3px;">
			<span style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email : </span>
			sale@gamecard.vn
        </p>
		<p style="padding-bottom:3px;">
			<span style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Zalo : </span>
			0931.829.095
        </p>
		<p style="padding-bottom:3px;">
			<span style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Facebook : </span>
			Gamecard.vn
        </p>
        </div>
    </div>
</div>      
<script type="text/javascript">
$(document).ready(function() {    
	//$('a#link').click(function(){  
	$('a#link').on('click', function(g){ 
	g.preventDefault();
	var nameshare = document.getElementById ("nameshare").value;	
	var linkshare = document.getElementById ("linkshare").value;	
	FB.ui({
		method: "stream.publish",
		display: "iframe",
		user_message_prompt: "Publish This!",
		message: "Rất mong sự ủng hộ của các game thủ!",
		attachment: {
			name: "Gamecard.vn",
			caption: "Gamecard.vn - Website bán thẻ game cho các game thủ Việt",
			description: "Gamecard.vn "+nameshare,
			href: linkshare,
			media:[{"type":"image","src":"http://gamecard.vn/resources/fb_gamecard.png","href":"http://gamecard.vn"}],
			properties:{
				"1":{"text":"Thẻ game online","href":"http://gamecard.vn/category/the-game/the-game.html"},
				"2":{"text":"Thẻ điện thoại","href":"http://gamecard.vn/category/the-game/the-dien-thoai.html"},					
			}
		},
		action_links: [{ text: 'Test yourself', href: 'http://gamecard.vn' }]
	},
	function(response) {
			if (response && response.post_id) {					
				$.ajax({
					type: "POST",
					url: "<?php echo SITE_PATH;?>/site/sharefb",
					}).done(function( msg ) {							
					alert( "Data Saved: " + msg );
				});
			} else {  alert('Post was not published.');	}
		}
	);
})


});
</script>
<div class="clearfix"></div>

