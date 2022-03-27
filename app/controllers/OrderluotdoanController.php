<?php

namespace app\controllers;
use Yii;
use yii\easyii\modules\trandau\models\Trandau;
use yii\easyii\modules\dudoan\models\Dudoan;
use amnah\yii2\user\models\User;
use yii\easyii\modules\userluotdoan\models\Userluotdoan;
use yii\web\NotFoundHttpException;
use yii\easyii\modules\shopcart\models\Order;
use app\models\Orderluotdoan;

use app\models\Currencyapi;

class OrderluotdoanController extends \yii\web\Controller {
   
    public function actionIndex() {
		/*
        $ordercomplete=Order::find()->where("(status='completed' or status='approved') and payment_method!='Changecards' and workflow=3 and order_id  > 48450")->all();
        foreach ($ordercomplete as $o){
            $checkorder=  Orderluotdoan::checkOrder($o->order_id);
            if($checkorder){}else{
                // start luot doan
                $ordertotal=(int)$o->order_total;
                if($o->payment_method=="OnecomND"||$o->payment_method=="OnecomVND"){
                    $mone = Currencyapi::find()->where("currency_from='USD' and currency_to='VND'")->one();
                    $usd = $ordertotal / $mone['rate'];
                    $luotdoan = (int)$usd / 250;
                }else{
                    $luotdoan = $ordertotal / 250;
                }
                $ld=(int)$luotdoan;
                if($ld>0){
                    $model = new Userluotdoan();
                    $us=  User::findOne($o->user_id);
                    $user_id=$o->user_id;
                    $email=$us['email'];
                    $luotdoan=$ld;
                    $vongduocdoan=2;
                    $check=  Userluotdoan::checkUserluotdoan($user_id, $email, $vongduocdoan);
                    if($check){
                        $model= Userluotdoan::find()->where("user_id=".$user_id." and email='".$email."' and vongduocdoan=".$vongduocdoan)->one();
                        $model->luotdoan=$model['luotdoan']+$luotdoan;
                        $resu=$model->save();
                    }else{
                        $model->user_id=$user_id;
                        $model->email=$email;
                        $model->luotdoan=$luotdoan;
                        $model->vongduocdoan=$vongduocdoan;
                        $resu=$model->save();
                    }
                    
                }// end luot doan
                $add_orderluotdoan=new Orderluotdoan();
                $add_orderluotdoan->order_id=$o->order_id;
                $add_orderluotdoan->save();
            }
            
            
        }*/
        return $this->render('index');
    }
}
