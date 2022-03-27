<?php
use yii\easyii\modules\page\api\Page;
use yii\easyii\modules\usermoney\api\Shopcart;
use yii\helpers\Html;

$page = Page::get('page-shopcart-success');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<div class="bre">
    <a class="bre1" href="<?php echo SITE_PATH;?>">Trang chủ</a>&nbsp;&nbsp;<span>/</span>&nbsp;&nbsp;
    <a class="bre1" href="<?php echo SITE_PATH;?>/nap">Nạp tiền</a>&nbsp;&nbsp;<span>/</span>&nbsp;&nbsp;
    <a class="bre2" href="#">Success</a>    
</div>
<div style="width: 253px; float: left; margin-bottom: 30px;">   
    <?php $this->beginContent('@app/views/layouts/random.php'); ?><?php $this->endContent(); ?>
    <div style="border-bottom: 1px solid #e4e4e4; height: 1px; margin-top: -1px;">&nbsp;</div>
</div>

<div class="huongdan-web" style="padding-bottom: 20px; margin-bottom: 5px; width: 940px; float: right;">
    <h1 class="title-main"><a href="#"><?= $page->seo('h1', $page->title) ?></a></h1> 
    <?= $page->text ?>
</div>
