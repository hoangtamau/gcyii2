<?php
use yii\easyii\modules\news\api\News;
use yii\easyii\modules\catalog\api\Catalog;
use yii\helpers\Html;
use yii\helpers\Url;
$asset= app\assets\AppAsset::register($this);
$this->title = $news->seo('title', $news->model->title);
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['tintuc/index']];
$this->params['breadcrumbs'][] = $news->model->title;
?>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icn_title.png" />
    Chi tiết
</h3>
<div class="main_content_right">    
    <h2 style="margin: 0px; padding-bottom: 10px; padding-top: 10px; color: #1b6ca2; font-size: 15px;">
        <?= $news->title ?>
    </h2>
    <?= $news->text ?>
</div>
