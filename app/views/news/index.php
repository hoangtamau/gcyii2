<?php
use yii\easyii\modules\news\api\News;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-news');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h3 class="titleh3">
    <span>
        Tin tức
    </span>            
</h3>
<div class="listrow-news">
    <?php 
    $i=1;
    foreach($news as $item) : ?>
    
    <div class="row-news" style="<?php if($i==1){?> padding-top: 20px; <?php }?>">
        <div class="col-md-3">            
            <?php //echo Html::img($item->thumb(160, 120)) ?>
            <img style="width: 160px; height: 120px; border:1px solid #ccc; padding:2px;" src="<?php echo SITE_PATH;?><?php echo $item->image;?>" />
        </div>
        <div class="col-md-9">
            <?= Html::a($item->title, ['news/view', 'slug' => $item->slug]) ?>
            <div style="font-size:11px;" class="small-muted"><i><?= $item->date ?></i></div>
            <p><?= $item->short ?></p>
            <p>
                <?php foreach($item->tags as $tag) : ?>
                    <a href="<?= Url::to(['/news', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                <?php endforeach; ?>
            </p>
        </div>
        <div class="cl"></div>
    </div>
    <?php $i++;?>    
    <?php endforeach; ?>
    <?= News::pages() ?>
    <div class="cl"></div>
</div>
























