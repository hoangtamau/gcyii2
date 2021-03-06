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
            'content' => 'Mua th??? game online Vi???t Nam thanh to??n qua Visa, Mastercard, Paypal cho game th??? trong v?? ngo??i n?????c, bao g???m th??? Zing zing xu, Th??? Gate, th??? VCoin VTC , th??? Oncash, th??? Garena, th??? appota  v?? c??c th??? ??i???n tho???i nh?? MobiFone, VinaPhone, VietTel uy t??n, giao d???ch nhanh ch??ng v?? nhi???u ??u ????i.'
        ]);
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'gamecard, th??? game online, th??? game vietnam, mua th??? game, mua th??? game online, b??n th??? game, b??n th??? game online, mua th??? gate, th??? zing,  mua th??? zing, mua th??? garena, b??n th??? garena, mua card oncash,  mua th??? oncash, b??n th??? oncash,  mua th??? gate, mua zing xu, mua th??? viettel, mua th??? vinaphone, mua th??? mobifone, mua th??? viettel, mua th??? mobifone, mua th??? vinaphone, mua th??? game ??? n?????c ngo??i'
        ]);
        return $this->render('test', ['addToCartForm' => new \app\models\AddToCartForm()]);
    }

}
