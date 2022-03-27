<?php

namespace app\controllers;
use Yii;
use yii\easyii\modules\trandau\models\Trandau;
use yii\easyii\modules\dudoan\models\Dudoan;
use amnah\yii2\user\models\User;
use yii\easyii\modules\userluotdoan\models\Userluotdoan;
use yii\web\NotFoundHttpException;

class DudoanController extends \yii\web\Controller {
    public $enableCsrfValidation = false;
    public function actionIndex() {
		return $this->redirect(SITE_PATH);
		
        if (!isset(Yii::$app->users->id)) {
            return $this->redirect(["/user/login"]);
        }
        $time=time();
        $trandau=  Trandau::find()->where("status=1 and time > ".$time)->all();
        return $this->render('index', [
             "trandau"=>$trandau       
        ]);
    }
    
    public function actionSend($id) {        
        $us=  User::findOne(Yii::$app->users->id);        
        $item = Trandau::findOne($id);
        if (!$item) {
            throw new NotFoundHttpException('Trandau not found');
        }
        // kiem tra user có đc doán tran này ko.
        $userluotdoan=  Userluotdoan::getUservongdau(Yii::$app->users->id, $us['email'], $item['vongdau']);
        if($userluotdoan){
            if($userluotdoan['luotdoan']>0){
                $model = new Dudoan();
                $success = 0;        
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $time=  time();
                    if($time>$item['time']){                        
                            Yii::$app->session->setFlash("dudoan","Trận đấu <span style='color:#000;'>".$item['title']."</span> đã đá rồi hoặc đang đá. Bạn không được dự đoán trận đấu này");                        
                    }else{
                        $model->email=$us['email'];
                        $model->vongdau=$item['vongdau'];
                        if($model->save()){                        
                            if($userluotdoan){
                                $userluotdoan->luotdoan=$userluotdoan['luotdoan']-1;
                                $userluotdoan->save();
                                Yii::$app->session->setFlash("dudoan","Gửi dự đoán trận đấu <span style='color:#000;'>".$item['title']."</span> thành công !");
                            }else{
                                Yii::$app->session->setFlash("dudoan","Lổi cập nhật lượt đoán !");
                            }
                        }else{
                            Yii::$app->session->setFlash("dudoan","Lổi trong quá trình gửi dự đoán trận đấu. Liên hệ với nhân viên Support để được hỗ trợ ");
                        }
                    }
                }else{
                    Yii::$app->session->setFlash("dudoan","Gặp sự cố trong quá trình dự đoán. Liên hệ với nhân viên Support để được hỗ trợ ");
                }
            }else{
                Yii::$app->session->setFlash("dudoan","Bạn đã hết lượt dự đoán");
            }// het luot doan
        }else{
            Yii::$app->session->setFlash("dudoan","Bạn không có lượt dự đoán ở vòng đấu này. Liên hệ với nhân viên Support để được hỗ trợ ");
        } // end // kiem tra user có đc doán tran này ko.
    
        return $this->redirect(["/du-doan-ty-so.html"]);
    }

}
