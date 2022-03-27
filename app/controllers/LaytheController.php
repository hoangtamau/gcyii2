<?php

namespace app\controllers;

use app\models\AddToCartForm;
use Yii;
use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\laythe\api\Shopcart;
use yii\web\NotFoundHttpException;
use yz\shoppingcart\ShoppingCart;

class LaytheController extends \yii\web\Controller {

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


        return $this->redirect(["/shopcart"]);
    }

    public function actionRemove($id) {
        $item = Catalog::get($id);
        if ($item) {
            //Shopcart::remove($id);
            \Yii::$app->cart->remove($item);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionUpdate($id, $quantity) {
        $item = Catalog::get($id);
        if ($item) {
            //Shopcart::update(Yii::$app->request->post('Good'));
            \Yii::$app->cart->update($item, $quantity);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionOrder($id, $token) {
        $order = Shopcart::order($id);
        if (!$order || $order->access_token != $token) {
            throw new NotFoundHttpException('Order not found');
        }

        return $this->render('order', ['order' => $order]);
    }

}
