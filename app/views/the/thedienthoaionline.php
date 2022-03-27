<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\modules\catalog\api\Catalog;
?>
<h1 class="title-main" style="margin-top: 10px;"><a href="#">Thẻ điện thoại</a></h1>
<div class="product-gird clearfix">    
    <ul class="box-product clearfix">        
        <?php $i = 1; ?>
        <?php foreach ($items as $item) : ?>                
            <?= $this->render('_item', ['item' => $item, 'i' => $i, 'tong' => count($items), 'addToCartForm' => $addToCartForm]) ?>                
            <?php $i++; ?>
        <?php endforeach; ?>     
        <?php $i = 1; ?>
        <?php foreach ($items1 as $item) : ?>                
            <?= $this->render('_item', ['item' => $item, 'i' => $i, 'tong' => count($items), 'addToCartForm' => $addToCartForm]) ?>                
            <?php $i++; ?>
        <?php endforeach; ?>
        <?php $i = 1; ?>
        <?php foreach ($items2 as $item) : ?>                
            <?= $this->render('_item', ['item' => $item, 'i' => $i, 'tong' => count($items), 'addToCartForm' => $addToCartForm]) ?>                
            <?php $i++; ?>
        <?php endforeach; ?>        
    </ul>
</div>
