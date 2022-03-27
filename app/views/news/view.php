<?php
use yii\easyii\modules\news\api\News;
use yii\helpers\Url;

$this->title = $news->seo('title', $news->model->title);
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['news/index']];
$this->params['breadcrumbs'][] = $news->model->title;
?>
<h3 class="titleh3">
    <span style="position:absolute; background-color:#fff; bottom:-1px; left:0px; border-right:1px solid #4cae4c; padding:0px 10px; color:#2a6a2a; border-left:1px solid #4cae4c; border-top:1px solid #4cae4c;">
    Chi tiết tin tức
    </span>            
</h3>
<div class="listrow-news">
    <div class="news-detail">
        <h2 style="margin: 0px; padding-bottom: 20px; padding-top: 10px; text-align: center;">
            <?= $news->seo('h1', $news->title) ?>
        </h2>
         <?= $news->text ?>
    </div>
    <div class="cl"></div>
</div>
