<?php
use yii\easyii\modules\news\api\News;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
$asset= app\assets\AppAsset::register($this);
$page = Page::get('page-news');
$this->title = "Tin tức";
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icn_title.png" />
    Chi tiết
</h3>
<div class="main_content_right">
    <?php foreach($news as $item) : ?>    
    <div class="row-news" style=" min-height: 100px; border-bottom: 1px dotted #e4e4e4; padding-top: 10px;">
        <div class="col-md-3">
            <img style="width: 135px; height: 83px; border:1px solid #ccc; padding:2px; float: left; margin-right: 10px;" src="<?php echo SITE_PATH;?><?php echo $item->image;?>" />
        </div>
        <div class="col-md-9">
            <?= Html::a($item->title, ['tintuc/chitiet', 'slug' => $item->slug]) ?>
            <div style="font-size:11px;" class="small-muted"><i><?= $item->date ?></i></div>
            <p><?= $item->short ?></p>            
        </div>
        <div class="cl"></div>
    </div> 
    <?php endforeach; ?>
    <?= News::pages() ?>
    <div class="cl"></div>
</div>


























