<?php

use yii\easyii\modules\page\api\Page;
use yii\easyii\modules\usermoney\api\Shopcart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\modules\catalog\models\Item;

$page = Page::get('page-shopcart');
$this->title = "Nạp tiền";
$this->params['breadcrumbs'][] = $page->model->title;
?>

<div class="bre">
    <a class="bre1" href="#">Trang chủ</a>&nbsp;&nbsp;<span>/</span>&nbsp;&nbsp;
    <a class="bre2" href="#">Nạp tiền</a>    
</div>
<div class="leftrandomproduct">   
    <?php $this->beginContent('@app/views/layouts/random.php'); ?><?php $this->endContent(); ?>
    <div style="border-bottom: 1px solid #e4e4e4; height: 1px; margin-top: -1px;">&nbsp;</div>
</div>
<style>
    .thanhtoan-web{
        padding:0px 10px;
    }
    .thanhtoan-web th{
        color:#b62e2e;
        font-weight: bold;
    }
    .table tr th{ border-bottom: 1px dotted #ccc; padding-top: 3px; background-color: #e4e4e4; padding-left: 10px;}
    .table tr td{ border-bottom: 1px dotted #ccc; padding-top: 3px; padding-left: 10px;}
    .send-shop input[type='text']{ padding:4px; width:220px;}
    .send-shop label{display:inline-block; width: 80px;}
    .modal-radio{ width: 100% !important;}
    .send-shop h4{ margin: 20px 0px 10px 0px;}
    .field-order-comment label{ vertical-align: top;}
    
</style>
<div class="thanhtoan-web">
    <h1 class="title-main"><a href="#">Nạp tiền</a></h1> 
        <div class="send-shop">
            <?= yii\easyii\modules\usermoney\api\Shopcart::form(['successUrl' => Url::to('/nap/success')]) ?>
        </div>
</div>