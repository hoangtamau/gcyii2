<?php
$asset = app\assets\AppAsset::register($this);
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\easyii\modules\shopcart\api\Shopcart;
use yii\easyii\modules\news\api\Testm;
$model = Yii::$app->getModule("user")->model("LoginForm");
$goodsCount = \Yii::$app->cart->getCount();
?>
<?php
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\Userl;
use amnah\yii2\user\models\Addresses;
use amnah\yii2\user\models\Countries;
use yii\easyii\helpers\Globals;
use yii\easyii\modules\managerctv\models\Managerctv;
use yii\easyii\modules\pricectv\models\Pricectv;
use yii\easyii\models\Admin;
$session = Yii::$app->session;
$clientId = '744065055458-cb74sujp0r2prh8u22ivarpo6p5eg2h4.apps.googleusercontent.com';
$clientSecret = 'TAaHOd4I1prKo92xOwwqUBnO'; 
$redirectURL = 'https://gamecard.vn/lienhe/test'; 
$gClient = new Google_Client();
$gClient->setApplicationName('Gamecard.vn');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);
$google_oauthV2 = new Google_Oauth2Service($gClient);
if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['gamecard11'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}
if (isset($_SESSION['gamecard11'])){
	$gClient->setAccessToken($_SESSION['gamecard11']);
}



if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	if($gpUserProfile['email']!=""){
		$randompass = Globals::generateRandomString(); 
		if ($user = User::findByUsername($gpUserProfile['email'])) {
			if (Yii::$app->getUser()->login($user)) {
				$getaddress = Addresses::findOne(['uid' => Yii::$app->user->id]);
				if ($getaddress) {
					Yii::$app->session->destroySession('notation');
					$notation = Globals::GetNotation($getaddress->country_code);
					Yii::$app->session->set('notation', $notation);
				} else {
					$location = Yii::$app->geoip->lookupLocation();
					$currency = Globals::GetNotation($location->countryCode);
					Yii::$app->session->set('notation', $currency);
				}
				
				if (empty($user->password)) {
					header("Location: https://gamecard.vn/tai-khoan.html");
				}
			}
		}
		$user = new Userl();
		$user->username = $gpUserProfile['email'];
		$user->email = $gpUserProfile['email'];
		$user->user_url = $gpUserProfile['link'];
		$user->setPassword($randompass);
		$user->generateAuthKey();
		$user->status = 1;
		if ($user->save()) {
			$getaddress = Addresses::findOne(['uid' => $user->id]);
			$address = $getaddress ? $getaddress : new Addresses;
			if (!$getaddress) {                                
				$country = Yii::$app->geoip->lookupLocation();				
				$countryname = Countries::find()->where('country_iso_code_2 = "' . $country->countryCode . '"')->one();
				$address->city = $country->city;
				if($country->postalCode==""){
					$address->postal_code = "1";
				}else{
					$address->postal_code = $country->postalCode;
				}				
				$address->country = $countryname['country_id'];
				$address->country_name = $countryname['country_name'];
				$address->country_code = $country->countryCode;
				$address->email = $user->email;
				$address->uid = $user->id;
				$address->created = time();
				$address->save(false);
			}
			/*luu link ctv
			if($session->has('random_key_ctv')){ 
				$randonkey=$session->get('random_key_ctv');
				$update_manager_ctv= Managerctv::find()->where("randonkey='".$randonkey."'")->one();
				$update_price= Pricectv::getPricectv($update_manager_ctv['price_id'], 1);
				if($update_manager_ctv){
					$update_manager_ctv->type=1;
					$update_manager_ctv->price=$update_price;
					$update_manager_ctv->user_id=$user->id;
					$update_manager_ctv->save(FALSE);
					unset($update_manager_ctv);
				}
			}
			//end luu link ctv*/
			//luu link ctv
			if($session->has('random_key_ctv')){ 
				$randonkey=$session->get('random_key_ctv');
				$update_manager_ctv= Managerctv::find()->where("randonkey='".$randonkey."'")->one();
				if($update_manager_ctv){
					$update_price= Pricectv::getPricectv($update_manager_ctv['price_id'], 1);
					if($update_manager_ctv){
						$update_manager_ctv->type=1;
						$update_manager_ctv->price=$update_price;
						$update_manager_ctv->user_id=$user->id;
						$update_manager_ctv->save(FALSE);
						unset($update_manager_ctv);
						$session->remove('random_key_ctv');
						$session->remove('forumsurl');
						$session->remove('customer_ip');
						$session->remove('set_time_ctv');
						$session->remove('username_ctv');
					}
				}else{
					//lay country
					if (!Yii::$app->session->get('notation')) {
						$location = Yii::$app->geoip->lookupLocation();
						$currency = Globals::GetNotation($location->countryCode);
						Yii::$app->session->set('notation', $currency);
					}
					$currency = Yii::$app->session->get('notation');
					if($currency!=""){
						$country= Countries::find()->where(['country_currency'=>$currency])->one();
						if($country){
							$country_name=$country['country_name'];
							$country_code=$country['country_iso_code_2'];
						}else{
							$country_name=NULL;
							$country_code=NULL;
						}
					}else{
						$country_name=NULL;
						$country_code=NULL;
					}                
					$forumsurl=$session->get('forumsurl');
					$customer_ip=$session->get('customer_ip');
					$slug=$session->get('username_ctv');
					$check_admins= Admin::checkExit($slug);
					if($check_admins){
						$check_m= Managerctv::checkExit($customer_ip);
						if(!$check_m){
							$admin_id= Admin::getIDAdmins($slug);
							$price_id= Pricectv::getTopID();
							$price= Pricectv::getPricectv($price_id, 1);
							$manager_ctv=new Managerctv();
							$manager_ctv->ctv_id=$admin_id;
							$manager_ctv->customer_ip=$customer_ip;
							$manager_ctv->country_code=$country_code;
							$manager_ctv->country_name=$country_name;
							$manager_ctv->price_id=$price_id;
							$manager_ctv->price=$price;
							$manager_ctv->forumsurl=$forumsurl;
							$manager_ctv->user_agent=$_SERVER['HTTP_USER_AGENT'];                
							$manager_ctv->date=date("d");
							$manager_ctv->month=date("m");
							$manager_ctv->year=date("Y");
							$manager_ctv->stringday=date("d")."/".date("m")."/".date("Y");
							$manager_ctv->created=time();
							$manager_ctv->randonkey=$session->get('random_key_ctv');
							$manager_ctv->type=1;
							$manager_ctv->user_id=$user->id;
							$manager_ctv->save();   
							unset($manager_ctv);
							$session->remove('random_key_ctv');
							$session->remove('forumsurl');
							$session->remove('customer_ip');
							$session->remove('set_time_ctv');
							$session->remove('username_ctv');
						}
					}//end else $update_manager_ctv
				}
			}
			//end luu link ctv
			if (Yii::$app->getUser()->login($user)) {
				header("Location: https://gamecard.vn");
			}
		}			
	}else{
		echo "Không lấy được Email từ google";
	}
}
	$authUrl = $gClient->createAuthUrl();
	//echo $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">Login</a>';
?>
<div class="col-xs-12 paddingleftright">
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-5 clearfix logo paddingleftright">
        <a href="<?php echo SITE_PATH; ?>" title="Gamecard">
            <p class="logan hidden-lg  hidden-md hidden-sm hidden-xs ">Thanh toán nhanh - Có thẻ liền</p>
            <img style="width:210px; height:105px;" title="Mua thẻ game online - Gamecard" alt="Mua thẻ game online - Gamecard" src="<?php echo $asset->baseUrl; ?>/images/logo.png" />
        </a>
        
    </div>    
    <?php if (!isset(Yii::$app->users->id)) { ?>    
        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8 clearfix loginw" >        
            <?php echo nodge\eauth\Widget::widget(array('action' => '/site/login')); ?>
            <div class="col-lg-12 logininput">            
                <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'action' => SITE_PATH . '/user/login',
                            'options' => ['class' => 'form-horizontal'],
                            'fieldConfig' => [
                            ],
                ]);
                ?>
                <?= $form->field($model, 'username')->textInput(array('placeholder' => 'Username/Email'))->label(false); ?>
                <?= $form->field($model, 'password')->passwordInput(array('placeholder' => 'Password'))->label(false); ?>
                <div class="clearfix"></div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 loginregister">
                    <a href="<?php echo SITE_PATH; ?>/create-new-account.html" class="submitlogins" title="Đăng ký">Đăng ký </a>                
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 loginlogin">
                    <input type="submit" value="Đăng nhập" class="submitlogins" />
                </div>
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4 loginforgetpass">
                    <a href="<?php echo SITE_PATH; ?>/forgot-password.html" title="Quên mật khẩu">Quên mật khẩu ?</a>
                </div>
                <div class="clearfix"></div>
                <?php ActiveForm::end(); ?>                        
            </div>
        </div>
    <?php } else { ?>
        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7 clearfix loginw infoussershopcart" >
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divlogininfo">
                <p class="welcome" >
                    <span >Wellcome :</span> <a href="<?php echo SITE_PATH ?>/tai-khoan.html" title="<?php echo Yii::$app->users->displayName; ?>"><?php echo Yii::$app->users->displayName; ?></a>
                </p>                
                <p class="shopcart">
                    <img title="Giỏ hàng" class="giohangimg" src="<?php echo $asset->baseUrl; ?>/images/giohang.png" alt="Giỏ hàng" />
                    <span id="itemnumber" ><?php echo $goodsCount; ?></span> Item | 
                    <span id="itemprice" >
                        <?= formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation')); ?> 
                    </span> <?php echo Yii::$app->session->get('notation'); ?>
                </p>                 
                <div class="btn-submit" >
                    <a  href="<?php echo SITE_PATH; ?>/shop-cart.html" title="Thanh toán">
                        <input type="submit" value="" class="submitthanhtoan" />
                    </a>
                    <a  href="<?php echo SITE_PATH ?>/user/order" title="Lấy thẻ">
                        <input type="submit" value="" class="submitlaythe" />
                    </a>
                    <a href="<?php echo SITE_PATH ?>/user/logout" title="Đăng xuất">
                        <input type="submit" value="" class="submitlogout" />
                    </a>
                </div>
            </div>        
        </div>
    <?php } ?>    

    <div class="col-lg-6 col-md-5 col-sm-12 hidden-xs supportonline">
        <div class="col-lg-2 col-md-4 col-sm-2 hotrovien paddingleftright">
            <div class="support-chat" >
<!-- BEGIN TAG CODE - DO NOT EDIT! --><div><div id="proactivechatcontainerh0adfdtp3s"></div><table border="0" cellspacing="2" cellpadding="2"><tr><td align="center" id="swifttagcontainerh0adfdtp3s"><div style="display: inline;" id="swifttagdatacontainerh0adfdtp3s"></div></td> </tr><tr><td align="center"><div style="MARGIN-TOP: 2px; WIDTH: 100%; TEXT-ALIGN: center;"></div></td></tr></table></div> <script type="text/javascript">var swiftscriptelemh0adfdtp3s=document.createElement("script");swiftscriptelemh0adfdtp3s.type="text/javascript";var swiftrandom = Math.floor(Math.random()*1001); var swiftuniqueid = "h0adfdtp3s"; var swifttagurlh0adfdtp3s="https://demandvi.com/visitor/index.php?/gamecard/LiveChat/HTML/HTMLButton/cHJvbXB0dHlwZT1jaGF0JnVuaXF1ZWlkPWgwYWRmZHRwM3MmdmVyc2lvbj00LjYyLjAuNDM5NCZwcm9kdWN0PUZ1c2lvbiZmaWx0ZXJkZXBhcnRtZW50aWQ9MTEmcm91dGVjaGF0c2tpbGxpZD0yJmN1c3RvbW9ubGluZT1odHRwcyUzQSUyRiUyRmdhbWVjYXJkLnZuJTJGSFRWLW9ubGluZS5wbmcmY3VzdG9tb2ZmbGluZT1odHRwcyUzQSUyRiUyRmdhbWVjYXJkLnZuJTJGSFRWLW9mZmxpbmUucG5nJmN1c3RvbWF3YXk9aHR0cHMlM0ElMkYlMkZnYW1lY2FyZC52biUyRkhUVi1hd2F5LnBuZyZjdXN0b21iYWNrc2hvcnRseT1odHRwcyUzQSUyRiUyRmdhbWVjYXJkLnZuJTJGSFRWLWF3YXkucG5nCmM0ZTc5ZGMwM2M0NzcyNmU3MzA1YzQzMTMyMDFlYWY3ZTU0ODViNWY=";setTimeout("swiftscriptelemh0adfdtp3s.src=swifttagurlh0adfdtp3s;document.getElementById('swifttagcontainerh0adfdtp3s').appendChild(swiftscriptelemh0adfdtp3s);",1);</script><!-- END TAG CODE - DO NOT EDIT! -->			
               
                <div id="chat_first_load" class="popover fade right support" role="tooltip" >
                    <div class="arrow"></div>
                    <div class="popover-title" >XIN CHÀO</div>
                    <div class="popover-content">
                        Bạn muốn được hỗ trợ ngay?
                    </div>     
                </div>
            </div>
            <p></p>
            <p>
                <a href="Skype:gamecardvn?chat" title="Chat skype">
                    <p class=" hidden-lg  hidden-md hidden-sm hidden-xs ">Chat skype</p>
                    <img alt="Chat skype" title=" chat skype" src="<?php echo $asset->baseUrl; ?>/images/skype.png" />
                </a>
            </p>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-3 hotrovienyahoo paddingleftright">            
            <p>				
                <span >Yahoo</span> : khachhangvae
            </p>
            <div>
                <img  src="<?php echo $asset->baseUrl; ?>/images/icon-zalo.png" alt="Zalo chat" title="Zalo chat"  />
                <div class="zalo chatonface shareonface hidden-xs" >
                </div>
                <img src="<?php echo $asset->baseUrl; ?>/images/icon-zalo-page.png" alt="Page Zalo" title="Page Zalo"  />
                <div class="zalopage chatonface shareonface hidden-xs" >
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-3 sfacebook paddingleftright">
            <img class="iconfacebook" src="<?php echo $asset->baseUrl; ?>/images/iconfacebook.png" alt="faecbook gamecard" title="Facebook" />
            <p class="p1">
                <a target="_blank" href="https://www.facebook.com/gamecard.vn" title="Chat on facebook">
                    <button  >Chat on facebook</button>
                </a>
            </p>
            <p id="bodyarea">
                <button  class="share_fb" >Share on facebook</button>
            </p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-4 sphone paddingleftright">
            <img class="iconphone" src="<?php echo $asset->baseUrl; ?>/images/iconhotline.png" alt="hotline" title="Hotline" />
            <p class="p1">
                <span>US :</span> 408-844-4577
            </p>
            <p class="au-vn" >
                <span>AU :</span> 03-9005-5699
            </p>
            <p class="au-vn" >
                <span>VN :</span> 028-62672181
            </p>
        </div>                           
    </div>
</div>

<div class="hidden-lg hidden-md hidden-sm col-xs-12 headerchplay" style="text-align:center">
	<a target="_blank" title="GamecardVN - Download App on Goolge Play Store" href="https://play.google.com/store/apps/details?id=vaeapp.gamecard.vn">
		<img style="margin-top:10px;" alt="GamecardVN - Download App on Goolge Play Store" src="<?php echo $asset->baseUrl; ?>/images/googlechplay.png" />
	</a>
</div>

