<?php
namespace app\controllers;
use app\models\GadgetsFilterForm;
use Yii;
use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\helpers\Globals;
use yii\web\NotFoundHttpException;
use yii\easyii\models\SeoText;
use yii\easyii\modules\text\api\Text;

use amnah\yii2\user\models\Countries;
use yii\easyii\models\Admin;
use yii\easyii\modules\managerctv\models\Managerctv;
use yii\easyii\modules\pricectv\models\Pricectv;

class TheController extends \yii\web\Controller
{
	
	 public function init() { 
	 parent::init();
        $this->layout = '@app/views/layouts/main_testlogingoogle';
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
	
    public function actionIndex()
    {
        return $this->render('index');        
    }
    public function actionCat($slug)
    {
		$str2=Globals::getCurrentPageURL(); 
        if (strlen(strstr($str2, "category/")) > 0) {
            return $this->redirect(SITE_PATH."/".$slug);
        }
		
        $filterForm = new GadgetsFilterForm();
        $cat = Catalog::cat($slug);    			
        if(!$cat){
            throw new NotFoundHttpException('Shop category not found.');
        }   
		$item_id=$cat->id;	
        $seotext = SeoText::find()->where('item_id ='.$item_id.' and class like "%catalog%" and class like "%Category%"')->one();
		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => $seotext['description']
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $seotext['keywords']
		]);
		$baiviet=  Text::get($slug);
		
        $filters = null;
        if($filterForm->load(Yii::$app->request->get()) && $filterForm->validate()) {
            $filters = $filterForm->parse();
        }
        return $this->render('cat', [
            'cat' => $cat,
			'baiviet'=>$baiviet,
            'items' => $cat->items([
                'pagination' => ['pageSize' => 15],
                'filters' => $filters
            ]),
            'filterForm' => $filterForm,
            'addToCartForm' => new \app\models\AddToCartForm()
        ]);
    }
	public function actionCategory()
    {
        $filterForm = new GadgetsFilterForm();
		//$trs1=SITE_PATH;
        //$str2=Globals::getCurrentPageURL();        
        //$slug = str_replace( $trs1.'/', '', $str2 );   
		
		$str2=Globals::getCurrentPageURL(); 
		$array=  explode("/", $str2);       
        $slug=($array[count($array)-1]);
		if (strlen(strstr($str2, "category/the-game")) > 0) {
            return $this->redirect(SITE_PATH."/".$slug);
        }
		/*
		if (!Yii::$app->session->get('notation')) {
            $ip = Yii::$app->getRequest()->getUserIP();
            $location = Yii::$app->ipAdd->getInfo($ip);
            $pos = strpos($ip, ".");
            if ($pos !== false) { // ip v4			
                $currency = Globals::GetNotation($location->country_code);
            } else {
                $currency = Globals::GetNotation($location->geoplugin_countryCode);
            } 
			Yii::$app->session->set('notation', $currency);
        } 
		if (Yii::$app->session->get('notation') == 'VND' && ($slug=="vcoin-vn.html")&&!isset(Yii::$app->users->id)) {
            throw new \yii\web\NotFoundHttpException('Category not found.');
        }*/
		
        $cat = Catalog::cat($slug);    
        if(!$cat){
            throw new NotFoundHttpException('Shop category not found.');
        }
		$item_id=$cat->id;	
        $seotext = SeoText::find()->where('item_id ='.$item_id.' and class like "%catalog%" and class like "%Category%"')->one();
		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => $seotext['description']
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $seotext['keywords']
		]);
		$baiviet=  Text::get($slug);
		
        $filters = null;
        if($filterForm->load(Yii::$app->request->get()) && $filterForm->validate()) {
            $filters = $filterForm->parse();
        }
        return $this->render('cat', [
            'cat' => $cat,
			'baiviet'=>$baiviet,
            'items' => $cat->items([
                'pagination' => ['pageSize' => 15],
                'filters' => $filters
            ]),
            'filterForm' => $filterForm,
            'addToCartForm' => new \app\models\AddToCartForm()
        ]);
    }	
	
	public function actionCategoryquatang()
    {
            
        $filterForm = new GadgetsFilterForm();
		//$trs1=SITE_PATH;
        //$str2=Globals::getCurrentPageURL();        
        //$slug = str_replace( $trs1.'/', '', $str2 );   
		
        $str2=Globals::getCurrentPageURL(); 
        $array=  explode("/", $str2);       
        $slug=($array[count($array)-1]);
        $slug=str_replace('.htm','', $slug ); 
        $cat = Catalog::cat($slug);
        if(!$cat){
            throw new NotFoundHttpException('Shop category not found.');
        }        
		$item_id=$cat->id;	
        $seotext = SeoText::find()->where('item_id ='.$item_id.' and class like "%catalog%" and class like "%Category%"')->one();
            \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $seotext['description']
            ]);
            \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => $seotext['keywords']
            ]);
        //$baiviet=  Text::get($slug);
		//echo $slug; die();
		$baiviet= \yii\easyii\modules\text\models\Text::find()->where("slug ='".$slug."'")->one();
        $baiviet=$baiviet['text'];
		//echo $baiviet; echo $slug; die();
		
        $filters = null;
        if($filterForm->load(Yii::$app->request->get()) && $filterForm->validate()) {
            $filters = $filterForm->parse();
        }
        return $this->render('catquatang', [
            'cat' => $cat,
            'baiviet'=>$baiviet,
            'items' => $cat->items([
                'pagination' => ['pageSize' => 15],
                'filters' => $filters
            ]),
            'filterForm' => $filterForm,
            'addToCartForm' => new \app\models\AddToCartForm()
        ]);
    }
	
    public function actionCatalog($slug)
    {     
		$str2=Globals::getCurrentPageURL(); 
        if (strlen(strstr($str2, "catalog/")) > 0) {
            return $this->redirect(SITE_PATH."/".$slug);
        }
        return $this->render('catalog', [
            'slug' => $slug,
            'addToCartForm' => new \app\models\AddToCartForm()
        ]);
    }
	public function actionCatalog1()
    {   
		$trs1=SITE_PATH;
        $str2=Globals::getCurrentPageURL();        
        $slug = str_replace( $trs1.'/', '', $str2 );
		$slug = str_replace( $trs1.':443', '', $slug );
		$slug = str_replace('/', '', $slug );
		$cat = Catalog::cat($slug);   
		if(!$cat){
            throw new NotFoundHttpException('Shop category not found.');
        }
        $item_id=$cat->id;	
        $seotext = SeoText::find()->where('item_id ='.$item_id.' and class like "%catalog%" and class like "%Category%"')->one();
		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => $seotext['description']
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $seotext['keywords']
		]);
		$baiviet=  Text::get($slug);
        return $this->render('catalog', [
            'slug' => $slug,
			'baiviet' => $baiviet,
			'titlecategory'=>$seotext['title'],
            'addToCartForm' => new \app\models\AddToCartForm()
        ]);
    }
    public function actionThedienthoai()    
            {        
        $filterForm = new GadgetsFilterForm();        
        $slug=17;        
        $cat = Catalog::cat($slug);        
        $cat1 = Catalog::cat(18);        
        $cat2 = Catalog::cat(19);        
        if(!$cat){            
            throw new NotFoundHttpException('Shop category not found.');
        }                
        $filters = null;        
        if($filterForm->load(Yii::$app->request->get()) && $filterForm->validate()) {            
            $filters = $filterForm->parse();        
            
        }        
        return $this->render('thedienthoaionline', [            
            'cat' => $cat,            
            'slug' => $slug,            
            'items' => $cat->items([                
                'pagination' => ['pageSize' => 15],                
                'filters' => $filters            
                    ]),            
            'items1' => $cat1->items([                
                'pagination' => ['pageSize' => 15],                
                'filters' => $filters            
                    ]),            
            'items2' => $cat2->items([                
                'pagination' => ['pageSize' => 15],                
                'filters' => $filters            
                    ]),            
            'filterForm' => $filterForm,            
            'addToCartForm' => new \app\models\AddToCartForm()        
            ]);            
        
        }
    public function actionSearch($text)
    {
        $text = filter_var($text, FILTER_SANITIZE_STRING);

        return $this->render('search', [
            'text' => $text,
            'items' => Catalog::items([
                'where' => ['or',['like', 'title', $text],['like', 'description', $text]],
            ])
        ]);
    }
    public function actionChitiet($slug)
    {
		$str2=Globals::getCurrentPageURL(); 
        if (strlen(strstr($str2, "product/qpal-the-bit")) > 0) {
            return $this->redirect(SITE_PATH."/".$slug.".html");
        }
        if (strlen(strstr($str2, "product/the-game")) > 0) {
            return $this->redirect(SITE_PATH."/".$slug.".html");
        }
        if (strlen(strstr($str2, "product/the-dien-thoai")) > 0) {
            return $this->redirect(SITE_PATH."/".$slug.".html");
        }
		//%E2%80%8B
        $item = Catalog::get($slug);
        if(!$item){
            throw new NotFoundHttpException('Item not found.');
        }
		$seotext = SeoText::find()->where('item_id ='.$item->id.' and class like "%catalog%" and class like "%Item%"')->one();
		//print_r($seotext);
		\Yii::$app->view->registerMetaTag([
			'name' => 'description',
			'content' => $seotext['description']
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'keywords',
			'content' => $seotext['keywords']
		]);
        return $this->render('chitiet', [
            'item' => $item,
            'addToCartForm' => new \app\models\AddToCartForm()
        ]);
    }
	public function actionLoadspk() {
        $id=$_POST['id'];
        $cat = Catalog::ItemCatogory($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        $arr="";
        foreach ($cat as $c) {
            
            $a='<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 paddingleftright product">
                <div class="col-xs-12 paddingleftright" style="text-align: center;">
                    <img style="cursor: pointer;" onclick="Addshopcart('.$c->item_id.')" src="'.SITE_PATH.$c->image.'" alt="'.$c->title.'" />
                </div>  
            </div>';
            $arr=$arr.$a;
        }
        return $arr;
    }
}
