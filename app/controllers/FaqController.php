<?php

namespace app\controllers;

use Yii;
use yii\easyii\helpers\Mail;
use app\components\iplocation;
use app\components\ip2locationlite;



class FaqController extends \yii\web\Controller {

    public function actionIndex() {
        echo var_dump( Yii::$app->ipAdd->getCountryCode('208.80.152.201')); //die();
        echo var_dump(Yii::$app->ipAdd->getInfo());
        $url = 'http://ip-api.com/json/27.32.186.240';
        $rCURL = curl_init();
        curl_setopt($rCURL, CURLOPT_URL, $url);
        curl_setopt($rCURL, CURLOPT_HEADER, 0);
        curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
        $aData = curl_exec($rCURL);
        curl_close($rCURL);
        $result = json_decode($aData);]
        return $this->render('index');
    }

}
