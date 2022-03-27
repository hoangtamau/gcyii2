<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AddToCartForm;
use yii\helpers\Url;

$asset = app\assets\AppAsset::register($this);
$addToCartForm = new \app\models\AddToCartForm();
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 paddingleftright product">
    <div class="col-xs-12 paddingleftright">
        <a class="bg-warning" href="<?php echo SITE_PATH ?>/<?= $it->slug ?>.html" title="<?= $it->title ?>">
            <img src="<?php echo SITE_PATH . $it->image; ?>" alt="<?= $it->title ?>" title="<?= $it->title ?>" />		
        </a>
    </div>      
    <div class="col-xs-12 paddingleftright">
        <a class="bg-warning" href="<?php echo SITE_PATH ?>/<?= $it->slug ?>.html" title="<?= $it->title ?>"><?= $it->title ?></a>                
    </div>
    <div class="col-xs-12 paddingleftright">
        <a class="bg-info"><?= formatprice($it->price, Yii::$app->session->get('notation')); ?> <?= Yii::$app->session->get('notation'); ?></a>
    </div>
    <div class="col-xs-12 paddingleftright">
        <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynow', 'id' => $it->id])]); ?>            
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-4 paddingleftright miniinput">
            <?= $form->field($addToCartForm, 'count')->textInput(['maxlength' => 255, 'style' => 'height:25px; padding:2px 0px 2px 3px;'])->label(false); ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-8 minisubmit">
            <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black', 'style' => 'margin-top:0px;']) ?>
        </div>                    
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
/*
  <div class="product">
  <?= Html::a('<img alt="'.$it->title.'" src="'.SITE_PATH.$it->image.'" />', ['the/chitiet', 'slug' => $it->slug]) ?>
  <div class="product-content">
  <h5 class="producttitle">
  <?= Html::a($it->title, ['the/chitiet', 'slug' => $it->slug]) ?>
  </h5>
  <p class="price">
  <?= formatprice($it->price, Yii::$app->session->get('notation')); ?> .<?= Yii::$app->session->get('notation');?>
  </p>
  <div class="b-imgblock_statistic">
  <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynow', 'id' => $it->id])]); ?>
  <?= $form->field($addToCartForm, 'count')->textInput(['maxlength' => 255, 'style' => 'padding:4px 2px 4px 4px; width:30px; border:1px solid #e4e4e4; border-radius:3px; margin-bottom:5px;','class'=>'textsoluong'])->label(false); ?>
  <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black']) ?>
  <?php ActiveForm::end(); ?>
  </div>
  </div>
  </div>-- */?>