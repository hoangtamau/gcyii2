<?php

namespace app\controllers;
use Yii;

use amnah\yii2\user\models\Countries;
use yii\easyii\helpers\Globals;
use yii\easyii\models\Admin;
use yii\easyii\modules\managerctv\models\Managerctv;
use yii\easyii\modules\pricectv\models\Pricectv;

class LienheController extends \yii\web\Controller
{
	public function init() {
		parent::init();
		$this->layout = '@app/views/layouts/main_testlogingoogle';
		
		//save ctv 30s
		$session = Yii::$app->session;
        if($session->has('random_key_ctv')){            
            $check_random= Managerctv::checkRandom($session->get('random_key_ctv'));
			if(!$check_random){
                if(time()-($session->get('set_time_ctv')+30)>0){ 
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
    public function actionIndex()
	{
	    //$location = Yii::$app->geoip->lookupLocation();
		//print_r($location);
		//$currency = Globals::GetNotation($location->countryCode);
		//Yii::$app->session->set('notation', $currency);
		$this->layout = '@app/views/layouts/main_testlogingoogle';
        return $this->render('index');
    }
	public function actionTest()
	{
		$this->layout = '@app/views/layouts/main_testlogingoogle';
		\Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Mua thẻ game online Việt Nam thanh toán qua Visa, Mastercard, Paypal cho game thủ trong và ngoài nước, bao gồm thẻ Zing zing xu, Thẻ Gate, thẻ VCoin VTC , thẻ Oncash, thẻ Garena, thẻ appota  và các thẻ điện thoại như MobiFone, VinaPhone, VietTel uy tín, giao dịch nhanh chóng và nhiều ưu đãi.'
        ]);
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'gamecard, thẻ game online, thẻ game vietnam, mua thẻ game, mua thẻ game online, bán thẻ game, bán thẻ game online, mua thẻ gate, thẻ zing,  mua thẻ zing, mua thẻ garena, bán thẻ garena, mua card oncash,  mua thẻ oncash, bán thẻ oncash,  mua thẻ gate, mua zing xu, mua thẻ viettel, mua thẻ vinaphone, mua thẻ mobifone, mua thẻ viettel, mua thẻ mobifone, mua thẻ vinaphone, mua thẻ game ở nước ngoài'
        ]);
        return $this->render('test', ['addToCartForm' => new \app\models\AddToCartForm()]);
    }

}
