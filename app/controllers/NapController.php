<?php

namespace app\controllers;

use app\models\UserMoney;
use Yii;
use yii\easyii\modules\usermoney\api\Shopcart;
use yii\web\NotFoundHttpException;

class NapController extends \yii\web\Controller {

    public function actionIndex() {

        if (!isset(Yii::$app->users->id)) {
            return $this->redirect(["/user/login"]);
        }        
        return $this->render('index');
    }
    public function actionSuccess() {
        return $this->render('success');
    }
}
