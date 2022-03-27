<?php
use yii\easyii\modules\feedback\api\Feedback;
use yii\easyii\modules\page\api\Page;
$page = Page::get('page-contact');
$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>

<h3 class="titleh3">
    <span style="position:absolute; background-color:#fff; bottom:-1px; left:0px; border-right:1px solid #4cae4c; padding:0px 10px; color:#2a6a2a; border-left:1px solid #4cae4c; border-top:1px solid #4cae4c;">
    <?= $page->seo('h1', $page->title) ?>
    </span>            
</h3>
<div class="listrow-news">
    <div class="news-detail">        
        <?= $page->text ?>
        <?php if(Yii::$app->request->get(Feedback::SENT_VAR)) : ?>
            <p> Message successfully sent</p>
        <?php else : ?>
            <div class="well well-sm">
                <?= Feedback::form() ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="cl"></div>
</div>
