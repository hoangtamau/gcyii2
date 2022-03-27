<?php
namespace app\controllers;

use Yii;
use app\models\Easyiisettings;
use app\models\Eventorder;
use yii\easyii\modules\eventcard\models\Eventcard;

class EventcardController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {   
        $eventcard = Eventcard::find()->where('status = 1')->orderBy('thutu ASC')->all();            
        return $this->render('index', [
            'eventcard' => $eventcard
        ]);
    }
    public function actionBuynow() {     
        $set=Easyiisettings::find()->where('setting_id=11')->one();
        if($set['value']==0){
            Yii::$app->session->setFlash("timeevent", "Đã hết giờ hoặc chưa đến giờ đặt mua hàng (Giờ Vàng)");
        }else{  
            $form = new Eventorder();        
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $form->date_created=  time();
                if($form->save(false)){
                    Yii::$app->session->setFlash("successevent", "Đặt mua thành công");
                }else{
                    Yii::$app->session->setFlash("faileevent", "Đặt mua thất bại");
                }
            }
        }
        return $this->redirect(SITE_PATH."/hiep-khach-san-the.html");
    }
}
