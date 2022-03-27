<?php

namespace app\controllers;

use app\models\AddToCartForm;
use Yii;
use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\shopcart\api\Shopcart;
use yii\web\NotFoundHttpException;
use yz\shoppingcart\ShoppingCart;

class ShopcartController extends \yii\web\Controller {
	public $enableCsrfValidation = false;
	public function init() {
		parent::init();
		$this->layout = '@app/views/layouts/main_testlogingoogle';
	}
    public function actionIndex() {
		
        if (!isset(Yii::$app->users->id)) {
            return $this->redirect(["/user/login"]);
        }
        $cart = \Yii::$app->cart;
        $products = $cart->getPositions();
        $total = $cart->getCost();
        return $this->render('index', [
                    'products' => $products,
                    'total' => $total,
        ]);
    }

    public function actionSuccess() {
        return $this->render('success');
    }

    public function actionAdd($id) {
        $item = Catalog::get($id);
        if (!$item) {
            throw new NotFoundHttpException('Item not found');
        }
        $form = new AddToCartForm();
        $success = 0;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            //$response = Shopcart::add($item->id, $form->count);
            \Yii::$app->cart->put($item, $form->count);
            $success = 1;
        }
        return $this->redirect(Yii::$app->request->referrer . '?' . AddToCartForm::SUCCESS_VAR . '=' . $success);
    }

    public function actionBuynow($id) {
        $item = Catalog::get($id);
        if (!$item) {
            throw new NotFoundHttpException('Item not found');
        }
        $form = new AddToCartForm();
        $success = 0;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            //$response = Shopcart::add($item->id, $form->count, $form->color);
            \Yii::$app->cart->put($item, $form->count);
            //$success = $response['result'] == 'success' ? 1 : 0;
        }


        return $this->redirect(["/shop-cart.html"]);
    }
    public function actionBuynowhome() {
        $id=$_POST['id_product'];     
		if($id==0){
			if (Yii::$app->session->hasFlash('catalog')) {
                Yii::$app->session->setFlash("menhgia","Chưa chọn mệnh giá");
                return $this->redirect(Yii::$app->session->getFlash("catalog"));
            }else{
                Yii::$app->session->setFlash("menhgia","Chưa chọn mệnh giá");
                return $this->redirect(SITE_PATH);
            }
		}
        $item = Catalog::get($id);
        if (!$item) {            
			throw new NotFoundHttpException('Item not found');
        }
        $form = new AddToCartForm();
        $success = 0;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            //$response = Shopcart::add($item->id, $form->count, $form->color);
            \Yii::$app->cart->put($item, $form->count);
            //$success = $response['result'] == 'success' ? 1 : 0;
        }
        return $this->redirect(["/shop-cart.html"]);
    }

    public function actionRemove($id) {
        $item = Catalog::get($id);
        if ($item) {
            //Shopcart::remove($id);
            \Yii::$app->cart->remove($item);
            //return $this->redirect(Yii::$app->request->referrer);
			return $this->redirect(["/shop-cart.html"]);
        }
    }
	
	public function actionRemovecart() {
        $id=$_POST['id'];
        $item = Catalog::get($id);
        if ($item) {
            //Shopcart::remove($id);
            \Yii::$app->cart->remove($item);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $cart = \Yii::$app->cart;            
            $total = $cart->getCost();
            $total=formatprice($total, Yii::$app->session->get('notation'));
			
			
			$products = $cart->getPositions();			
			$checkzing="nozing";$checkquatang="noquatang";$checklinkdo="nolink";
			foreach ($products as $pr){
				if($pr->id==71){
					$checkzing="yeszing";
				}
				if($pr->id>250&&$pr->id<256){
					$checklinkdo="yeslink";
				}
				if($pr->quatang==1){
                    $checkquatang="yesquatang"; 
                }
			}
			
			$goodsCount = \Yii::$app->cart->getCount();       
            $itemnumber  = $goodsCount;
            $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));
            
            $arr=$itemnumber.":".$itemprice.":".$total.":".$checkzing.":".$checkquatang.":".$checklinkdo;
                    
            return $arr;
        }
    }
    public function actionUpdateasc() {
        $id=$_POST['id'];
        
        $cart = \Yii::$app->cart;
        $products = $cart->getPositions();
        $sl=0;
        foreach ($products as $pr){
            if($pr->id==$id){
                $sl=$pr->getQuantity();
                $price=$pr->price;
            }
        }
        if($sl==0){ // remove
            $item = Catalog::get($id);
            if ($item) {
                //Shopcart::remove($id);
                \Yii::$app->cart->remove($item);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $cart = \Yii::$app->cart;            
                $total = $cart->getCost();
                $total=formatprice($total, Yii::$app->session->get('notation'));

                $goodsCount = \Yii::$app->cart->getCount();       
                $itemnumber  = $goodsCount;
                $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));
                $arr=$itemnumber.":".$itemprice.":".$total;
                return $arr;
            }
        }else{
            $quantity=$sl+1;
            $item = Catalog::get($id);
            if ($item) {            
                \Yii::$app->cart->update($item, $quantity);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $cart = \Yii::$app->cart;            
                $total = $cart->getCost();
                $total=formatprice($total, Yii::$app->session->get('notation'));

                $goodsCount = \Yii::$app->cart->getCount();       
                $itemnumber  = $goodsCount;
                $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));
                $subtotal = $price*$quantity;
                $subtotal = formatprice($subtotal, Yii::$app->session->get('notation'));
                $arr=$itemnumber.":".$itemprice.":".$total.":".$quantity.":".$subtotal;

                return $arr;
            }
        }
    }
    
    public function actionUpdatedesc() {
        $id=$_POST['id'];        
        $cart = \Yii::$app->cart;
        $products = $cart->getPositions();
        $sl=0;
        foreach ($products as $pr){
            if($pr->id==$id){
                $sl=$pr->getQuantity();
                $price=$pr->price;
            }
        }
		
        if($sl==0||$sl==1){ // remove
            $item = Catalog::get($id);
            if ($item) {
                \Yii::$app->cart->remove($item);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $cart = \Yii::$app->cart;            
                $total = $cart->getCost();
                $total=formatprice($total, Yii::$app->session->get('notation'));
                $remove="remove";
                $goodsCount = \Yii::$app->cart->getCount();       
                $itemnumber  = $goodsCount;
                $quantity=0;
                $subtotal=0;
				
				$products = $cart->getPositions();		
				$checkzing="nozing";$checklinkdo="nolink";
				foreach ($products as $pr){
					if($pr->id==71){
						$checkzing="yeszing";
					}
					if($pr->id>250&&$pr->id<256){
						$checklinkdo="yeslink";
					}
				}
				
                $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));
                $arr=$itemnumber.":".$itemprice.":".$total.":".$quantity.":".$subtotal.":".$remove.":".$checkzing.":".$checklinkdo;
                return $arr;
            }
        }else{
            $quantity=$sl-1;
            $item = Catalog::get($id);
            if ($item) {  
				$checkzing="2";
				$checklinkdo="2";
                \Yii::$app->cart->update($item, $quantity);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $cart = \Yii::$app->cart;            
                $total = $cart->getCost();
                $total=formatprice($total, Yii::$app->session->get('notation'));
                $remove="noremove";
                $goodsCount = \Yii::$app->cart->getCount();       
                $itemnumber  = $goodsCount;
                $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));
                $subtotal = $price*$quantity;
                $subtotal = formatprice($subtotal, Yii::$app->session->get('notation'));
                $arr=$itemnumber.":".$itemprice.":".$total.":".$quantity.":".$subtotal.":".$remove.":".$checkzing.":".$checklinkdo;

                return $arr;
            }
        }
    }
	
    public function actionUpdate($id, $quantity) {
        $item = Catalog::get($id);
        if ($item) {
            //Shopcart::update(Yii::$app->request->post('Good'));
            \Yii::$app->cart->update($item, $quantity);
            //return $this->redirect(Yii::$app->request->referrer);
			return $this->redirect(["/shop-cart.html"]);
        }
    }

    public function actionOrder($id, $token) {
        $order = Shopcart::order($id);
        if (!$order || $order->access_token != $token) {
            throw new NotFoundHttpException('Order not found');
        }

        return $this->render('order', ['order' => $order]);
    }
	
	public function actionAddshopcart() {
        $id=$_POST['id'];
        $item = Catalog::get($id);
        $cart = \Yii::$app->cart;
        $products = $cart->getPositions();
        $sl=0;
		$checkzing="nozing";$checklinkdo="nolink";
        foreach ($products as $pr){
			if($pr->id==71){
				$checkzing="yeszing";
			}
			if($pr->id>250&&$pr->id<256){
				$checklinkdo="yeslink";
			}
            if($pr->id==$id){
                $sl=$pr->getQuantity();
                $price=$pr->price;
            }
        }
		if($id>250&&$id<256&&$checklinkdo=="nolink"){			
			$checklinkdo="yeslink1";
		}else{
			$checklinkdo="nolink";
		}
		if($id==71&&$checkzing=="nozing"){			
			$checkzing="yeszing1";
		}else{
			$checkzing="nozing";
		}
        if($sl!=0){
            $quantity=$sl+1;
            \Yii::$app->cart->update($item,$quantity);
            $cart = \Yii::$app->cart;            
            $total = $cart->getCost();
            $total=formatprice($total, Yii::$app->session->get('notation'));
            $goodsCount = \Yii::$app->cart->getCount();       
            $itemnumber  = $goodsCount;
            $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));
            $subtotal = $price*$quantity;
            $subtotal = formatprice($subtotal, Yii::$app->session->get('notation'));
            $beforeshopcart="update";
            $arr=$itemnumber."::".$itemprice."::".$total."::".$quantity."::".$subtotal."::".$beforeshopcart."::".$checkzing."::".$checklinkdo;
        }else{      
            $quantity=1;
            \Yii::$app->cart->put($item, $quantity);  
            $price=$item->price;         
            $pr=formatprice($item->price, Yii::$app->session->get('notation'));
            $subtotal=$pr;
            $notation=Yii::$app->session->get('notation');       
            $cart = \Yii::$app->cart;            
            $total = $cart->getCost();
            $total=formatprice($total, Yii::$app->session->get('notation'));            
            $goodsCount = \Yii::$app->cart->getCount();       
            $itemnumber  = $goodsCount;
            $itemprice = formatprice(\Yii::$app->cart->getCost(), Yii::$app->session->get('notation'));

            $beforeshopcart='<div class="col-lg-12 paddingleftright rowshopcart" id="cart'.$id.'">
            <div class="col-lg-4 col-md-3 col-sm-4 col-xs-4 minishopcartitem">
                <img class="hidden-sm hidden-xs" width="90px" title="" src="'.SITE_PATH.$item->image.'">
                <a href="'.SITE_PATH.$item->slug.'.html">'.$item->title.'</a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 paddingleftright">            
                <div style="width:25px; float: left;">
                    <input id="buttondesc'.$id.'" style="width:25px; height: 25px;" type="button" onclick="Updatedesc('.$id.')" value="-">
                </div>
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 paddingleftright" style="position: relative;width:38px; text-align: center; float: left; padding-top:3px;">
                    <div class="divload'.$id.'">&nbsp;</div>
                    <span id="soluong'.$id.'">'.$quantity.'</span>
                </div>
                <div style="width:25px; float: left;">
                    <input id="buttonasc'.$id.'" style="width:25px; height: 25px;" type="button" onclick="Updateasc('.$id.')" value="+">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs paddingleftright">'.$pr." ".$notation.'</div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">
                <span id="subtotal'.$id.'">'.$pr.'</span>
                '.$notation.'
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 minishopcartr">
                <span style="color:red; cursor: pointer;" id="remove" onclick="Removecart('.$id.')" class="glyphicon glyphicon-trash">&nbsp;</span>            
            </div>
            <div class="clearfix" id="beforeshopcart">&nbsp;</div>
        </div>';

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;            
            $arr=$itemnumber."::".$itemprice."::".$total."::".$quantity."::".$subtotal."::".$beforeshopcart."::".$checkzing."::".$checklinkdo;
          }
        return $arr; 
    }// end add shop cart

}
