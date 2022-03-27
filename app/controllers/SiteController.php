<?php

namespace app\controllers;

use amnah\yii2\user\models\User;
use amnah\yii2\user\models\Userl;
use Yii;
use yii\easyii\modules\page\models\Page;
use yii\web\Controller;
use app\models\Currencyapi;
use yii\easyii\helpers\Globals;
use amnah\yii2\user\models\Addresses;
use amnah\yii2\user\models\Countries;
use amnah\yii2\user\models\Itemcart;
use amnah\yii2\user\models\Zone;
use yii\easyii\modules\usermoney\models\UserHistoryMoney;
use yii\easyii\modules\usermoney\models\UserMoney;
use yii\easyii\modules\votemissgame\models\Votemissgame;
use yii\easyii\modules\news\models\News;
use yii\easyii\modules\totalvote\models\Totalvote;
use yii\easyii\models\Admin;
use yii\easyii\modules\managerctv\models\Managerctv;
use yii\easyii\modules\pricectv\models\Pricectv;
$session = Yii::$app->session;

class SiteController extends Controller {

    public $enableCsrfValidation = false;

    public function init() {
        parent::init();
        
        if (!Yii::$app->session->get('notation')) {
            $location = Yii::$app->geoip->lookupLocation();
            $currency = Globals::GetNotation($location->countryCode);
            Yii::$app->session->set('notation', $currency);
        }
		/*if (!Yii::$app->session->get('notation')) {
			$ip=Yii::$app->getRequest()->getUserIP();
			$location = Yii::$app->ipAdd->getInfo($ip);
			$pos = strpos($ip, ".");
			if ($pos !== false) { // ip v4
				$currency = Globals::GetNotation($location->countryCode);            
			}else{
				$currency = Globals::GetNotation($location->geoplugin_countryCode);
			} 		
			Yii::$app->session->set('notation', $currency);
		}*/
		
		
        $timechange = 10800;
        $currency = Yii::$app->session->get('notation');
		/*
		if (strtoupper(trim($currency)) != 'USD') {
            $cur = Currencyapi::findOne(['currency_from' => 'USD', 'currency_to' => $currency]);
            $timedb = $cur->timestamp;
            if ((time() - intval($timedb)) >= $timechange) {

                $endpoint = 'live';
                $access_key = 'f0153ce2d3070635c78851ea0d267dc6';
                $ch = curl_init('http://apilayer.net/api/' . $endpoint . '?access_key=' . $access_key . '&currencies=EUR,VND,AUD,KRW&source=USD&format=1');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($ch);
                curl_close($ch);
                $exchangeRates = json_decode($json, true);

                if (count($exchangeRates['quotes']) > 0) {

                    $cur2 = Currencyapi::findOne(['currency_from' => 'USD', 'currency_to' => 'VND']);
                    $cur2->rate = $exchangeRates['quotes']['USDVND'];
                    $cur2->timestamp = time();
                    $cur2->save();
                    unset($cur2);

                    $cur2 = Currencyapi::findOne(['currency_from' => 'USD', 'currency_to' => 'AUD']);
                    $cur2->rate = floatval($exchangeRates['quotes']['USDAUD']) * 1.02;
                    $cur2->timestamp = time();
                    $cur2->save();
                    unset($cur2);
					$cur2 = Currencyapi::findOne(['currency_from' => 'AUD', 'currency_to' => 'USD']);
                    $cur2->rate = 1 / (float)($exchangeRates['quotes']['USDAUD']);
                    $cur2->timestamp = time();
                    $cur2->save();
                    unset($cur2);

                    $cur2 = Currencyapi::findOne(['currency_from' => 'USD', 'currency_to' => 'KRW']);
                    $cur2->rate = $exchangeRates['quotes']['USDKRW'];
                    $cur2->timestamp = time();
                    $cur2->save();

                    unset($cur2);
                    $cur3 = Currencyapi::findOne(['currency_from' => 'KRW', 'currency_to' => 'USD']);
                    $rate = 1 / (float) ($exchangeRates['quotes']['USDKRW']);
                    $cur3->rate = $rate;
                    $cur3->timestamp = time();
                    $cur3->save();
                    unset($cur3);

                    $cur2 = Currencyapi::findOne(['currency_from' => 'USD', 'currency_to' => 'EUR']);
                    $cur2->rate = $exchangeRates['quotes']['USDEUR'];
                    $cur2->timestamp = time();
                    $cur2->save();
                    unset($cur2);
                    
                    $cur3 = Currencyapi::findOne(['currency_from' => 'EUR', 'currency_to' => 'USD']);
                    $rate = 1 / (float) ($exchangeRates['quotes']['USDEUR']);
                    $cur3->rate = $rate;
                    $cur3->timestamp = time();
                    $cur3->save();
                    unset($cur3);
                }
            }
        }*/
		//save ctv 30s
		$session = Yii::$app->session;
        if($session->has('random_key_ctv')){
			$check_random= Managerctv::checkRandom($session->get('random_key_ctv'));
			if(!$check_random){
				if(time()-($session->get('set_time_ctv')+30)>0){                    
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
							$price= Pricectv::getPricectv($price_id, 0);
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
							$manager_ctv->save();
						}
					}
				}
			}
        }
		// end save ctv 30s
    }

    public function behaviors() {
        return array(
            'eauth' => array(
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => array('login'),
            ),
        );
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex() {
        $s01 = microtime(true) * 10000;
		$this->layout = '@app/views/layouts/main_testlogingoogle';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Mua thẻ game online Việt Nam thanh toán qua Visa, Mastercard, Paypal cho game thủ trong và ngoài nước, bao gồm thẻ Zing zing xu, Thẻ Gate, thẻ VCoin VTC , thẻ Oncash, thẻ Garena, thẻ appota  và các thẻ điện thoại như MobiFone, VinaPhone, VietTel uy tín, giao dịch nhanh chóng và nhiều ưu đãi.'
        ]);
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'gamecard, thẻ game online, thẻ game vietnam, mua thẻ game, mua thẻ game online, bán thẻ game, bán thẻ game online, mua thẻ gate, thẻ zing,  mua thẻ zing, mua thẻ garena, bán thẻ garena, mua card oncash,  mua thẻ oncash, bán thẻ oncash,  mua thẻ gate, mua zing xu, mua thẻ viettel, mua thẻ vinaphone, mua thẻ mobifone, mua thẻ viettel, mua thẻ mobifone, mua thẻ vinaphone, mua thẻ game ở nước ngoài'
        ]);
        $s02 = microtime(true) * 10000;
        //echo ($s02-$s01);
        return $this->render('index', ['addToCartForm' => new \app\models\AddToCartForm()]);
    }
	
	public function actionCtv($slug) { 
        /*lay country
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
        $session = Yii::$app->session;
        $forumsurl=$_GET['forumsurl'];
        $customer_ip=$_SERVER['REMOTE_ADDR'];
        $check_admins= Admin::checkExit($slug);
        if($check_admins){
            $check_m= Managerctv::checkExit($customer_ip);
            if(!$check_m){
                $admin_id= Admin::getIDAdmins($slug);
                $price_id= Pricectv::getTopID();
                $price= Pricectv::getPricectv($price_id, 0);
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
                $manager_ctv->randonkey=Globals::generateRandomString(20);
                $manager_ctv->save();
                $session->set('random_key_ctv', $manager_ctv->randonkey);
            }
        }*/
		$session = Yii::$app->session;
        $forumsurl=$_GET['forumsurl'];
        $customer_ip=$_SERVER['REMOTE_ADDR'];
        $check_admins= Admin::checkExit($slug);
        if($check_admins){
            $check_m= Managerctv::checkExit($customer_ip);
            if(!$check_m){                
                $session->set('random_key_ctv', Globals::generateRandomString(20));
                $session->set('forumsurl', $forumsurl);
                $session->set('customer_ip',$customer_ip);
                $session->set('set_time_ctv', time());
                $session->set('username_ctv', $slug);
            }
        }
        return $this->redirect(SITE_PATH);
    }
	
	public function actionLogingmail() {		
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Mua thẻ game online Việt Nam thanh toán qua Visa, Mastercard, Paypal cho game thủ trong và ngoài nước, bao gồm thẻ Zing zing xu, Thẻ Gate, thẻ VCoin VTC , thẻ Oncash, thẻ Garena, thẻ appota  và các thẻ điện thoại như MobiFone, VinaPhone, VietTel uy tín, giao dịch nhanh chóng và nhiều ưu đãi.'
        ]);
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'gamecard, thẻ game online, thẻ game vietnam, mua thẻ game, mua thẻ game online, bán thẻ game, bán thẻ game online, mua thẻ gate, thẻ zing,  mua thẻ zing, mua thẻ garena, bán thẻ garena, mua card oncash,  mua thẻ oncash, bán thẻ oncash,  mua thẻ gate, mua zing xu, mua thẻ viettel, mua thẻ vinaphone, mua thẻ mobifone, mua thẻ viettel, mua thẻ mobifone, mua thẻ vinaphone, mua thẻ game ở nước ngoài'
        ]);
        return $this->render('index_login_gmail', ['addToCartForm' => new \app\models\AddToCartForm()]);
    }

    public function actionLogin() {
        //them doan nay 
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');

        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));
			//echo var_dump($eauth);die();
			//echo $eauth->authenticate(); die();
            try {
                if ($eauth->authenticate()) {
                    if ($eauth->getAttribute('email') != "") {
                        $randompass = Globals::generateRandomString();
                        //echo $randompass;
                        //echo var_dump($eauth->getAttributes());die();
                        //$identity = User::findByEAuth($eauth);					
                        //echo var_dump($identity);

                        if ($user = User::findByUsername($eauth->getAttribute('email'))) {
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
                                    $eauth->redirect('/user/account');
                                }
                                //return $this->goHome();
                                $eauth->redirect();
                            }
                        }

                        $user = new Userl();
                        $user->username = $eauth->getAttribute('email');
                        $user->email = $eauth->getAttribute('email');
                        $user->user_url = $eauth->getAttribute('url');

                        $user->setPassword($randompass);

                        //Yii::$app->session->setFlash("successpasslogin",$randompass);
                        $user->generateAuthKey();
                        //$user->role_id = 2;
                        $user->status = 1;
                        if ($user->save()) {
                            $getaddress = Addresses::findOne(['uid' => $user->id]);
                            $address = $getaddress ? $getaddress : new Addresses;
                            if (!$getaddress) {
                                //$session = Yii::$app->session;
                                //$country = $session->get('country');
                                $country = Yii::$app->geoip->lookupLocation();
                                $countryname = Countries::find()->where('country_iso_code_2 = "' . $country->countryCode . '"')->one();
                                $address->city = $country->city;
                                $address->postal_code = $country->postalCode;
                                $address->country = $countryname['country_id'];
                                $address->country_name = $countryname['country_name'];
                                $address->country_code = $country->countryCode;
                                $address->email = $user->email;
                                $address->uid = $user->id;
                                $address->created = time();
                                $address->save();
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
                                        $session->remove('random_key_ctv');$session->remove('save_ctv');$session->remove('forumsurl');
                                        $session->remove('customer_ip');$session->remove('set_time_ctv');$session->remove('username_ctv');
                                    }
                                }else{
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
							
                            if (Yii::$app->getUser()->login($user, 876777)) {
                                return $this->goHome();
                                //$eauth->redirect();
                            }
                        }
                        // special redirect with closing popup window
                        $eauth->redirect();
                    } else {
                        Yii::$app->session->setFlash("falseloginsocial", "Không lấy được thông tin email. Liên hệ với nhân viên để được hỗ trợ !");
                        return $this->goHome();
                    }
                } else {
                    // close popup window and redirect to cancelUrl
					//Yii::$app->session->setFlash("falseloginsocial", " Google API is update!");
					$eauth->cancel();					
                }
            } catch (\nodge\eauth\ErrorException $e) {

                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());
                //close popup window and redirect to cancelUrl
                $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
        //end
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->get('returnUrl')) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->get('returnUrl'));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {

        Yii::$app->users->logout();

        return $this->goHome();
    }

    public function actionGetsalecurrency() {
        echo "a";
    }

    public function actionSharefb() {
        $email = Yii::$app->users->email;
        if ($email != "") {
            $share = new \app\models\Sharefb();
            $share->email = $email;
            $share->time = time();
            $share->status = 1;
            $share->save();
            $result = "Share on facebook successfull";
        } else {
            $result = "Đăng nhập trước khi share";
        }
        echo json_encode($result);
        Yii::app()->end();
    }
    
}
