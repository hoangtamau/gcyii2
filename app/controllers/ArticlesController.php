<?php

namespace app\controllers;

use Yii;
use yii\easyii\modules\article\api\Article;
use yii\easyii\models\SeoText;
use yii\easyii\helpers\Data;
use yii\easyii\helpers\Globals;

use amnah\yii2\user\models\Countries;
use yii\easyii\models\Admin;
use yii\easyii\modules\managerctv\models\Managerctv;
use yii\easyii\modules\pricectv\models\Pricectv;

class ArticlesController extends \yii\web\Controller {

	public function init() {
		parent::init();
		$this->layout = '@app/views/layouts/main_testlogingoogle';
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
							$session->set('save_ctv', TRUE);
						}
					}
				}
			}
        }
		// end save ctv 30s
	}
	
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionCat($slug, $tag = null) {
        $cat = Article::cat($slug);
        if (!$cat) {
            throw new \yii\web\NotFoundHttpException('Article category not found.');
        }
        return $this->render('cat', [
                    'cat' => $cat,
                    'items' => $cat->items(['tags' => $tag, 'pagination' => ['pageSize' => 2]])
        ]);
    }

    public function actionView($slug) {
        $str2 = Globals::getCurrentPageURL();

        $article = Article::get($slug);
        if (!$article) {
            if (strlen(strstr($str2, "%E2%80%8B")) > 0) {
                $slug = preg_replace('/\p{C}+/u', "", $slug);
                return $this->redirect(SITE_PATH . "/detail-news/" . $slug);
            }
            if (strlen(strstr($str2, "%25E2%2580%258B")) > 0) {
                $slug = preg_replace('/\p{C}+/u', "", $slug);
                return $this->redirect(SITE_PATH . "/detail-news/" . $slug);
            }
        }
       

        if (!Yii::$app->session->get('notation')) {
            $location = Yii::$app->geoip->lookupLocation();
            $currency = Globals::GetNotation($location->countryCode);
            Yii::$app->session->set('notation', $currency);
        }
        if (Yii::$app->session->get('notation') == 'VND' && $article->id_khuyenmai == 2) {
            throw new \yii\web\NotFoundHttpException('Article not found.');
        }

        if (!$article) {
            throw new \yii\web\NotFoundHttpException('Article not found.');
        }
        $seotext = SeoText::find()->where('item_id =' . $article->id . ' and class like "%article%"  and class like "%Item%"')->one();
        if ($seotext) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $seotext['description']
            ]);
            \Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $seotext['keywords']
            ]);
        }
        return $this->render('view', [
                    'title' => $seotext['title'],
                    'article' => $article
        ]);
    }

}
