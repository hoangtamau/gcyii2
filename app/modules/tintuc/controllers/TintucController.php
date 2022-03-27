<?php
namespace app\modules\tintuc\controllers;

use yii\easyii\modules\news\api\News;

class TintucController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        return $this->render('index',[
            'news' => News::items(['tags' => $tag, 'pagination' => ['pageSize' => 10]])
        ]);
    }

    public function actionView($slug)
    {
        $news = News::get($slug);
        if(!$news){
            throw new \yii\web\NotFoundHttpException('News not found.');
        }
        return $this->render('view', [
            'news' => $news
        ]);
    }
    public function actionChitiet($slug)
    {
        $news = News::get($slug);
        if(!$news){
            throw new \yii\web\NotFoundHttpException('News not found.');
        }
        return $this->render('view', [
            'news' => $news
        ]);
    }
}
