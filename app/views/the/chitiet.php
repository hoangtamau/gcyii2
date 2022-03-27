<?php

use app\models\AddToCartForm;
use yii\easyii\modules\catalog\api\Catalog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\helpers\Image;
use yii\widgets\ActiveForm;

$addToCartForm = new \app\models\AddToCartForm();
$asset = app\assets\AppAsset::register($this);
$this->title = $item->seo('title', $item->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Shop', 'url' => ['shop/index']];
$this->params['breadcrumbs'][] = ['label' => $item->cat->title, 'url' => ['shop/cat', 'slug' => $item->cat->slug]];
$this->params['breadcrumbs'][] = $item->model->title;

$colors = [];
if (!empty($item->data->color) && is_array($item->data->color)) {
    foreach ($item->data->color as $color) {
        $colors[$color] = $color;
    }
}
?>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />
    Chi tiết
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <?php if (Yii::$app->request->get(AddToCartForm::SUCCESS_VAR)) { ?>
        <h4 class="text-success"><i class="glyphicon glyphicon-ok"></i> Added to cart successful</h4>
    <?php } ?> 
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 paddingleftright chitietimg">
        <?php
        if ($item->quatang == 0) {
            $qua = 0;
            ?>
            <img src="<?php echo SITE_PATH . $item->image; ?>" alt="<?= $item->title ?>" title="<?php echo $item->title ?>" />
            <?php
        } else {
            $qua = 1;
            ?>
            <img  data-toggle="modal" data-target="#myModal" style="padding:4px;" src="<?php echo Image::thumb($item->image, 200, 170) ?>" data-large="<?php echo Image::thumb($item->image, 200, 170) ?>" alt="" data-description="" />
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-body">
                        <img src="<?php echo $item->image; ?>" class="img-responsive">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
        <h2 class="img-thumbnail" style="border-radius:30px;box-shadow:0px 1px 5px 1px #ddd;margin-bottom:5px;">
            <a style="text-decoration: none;" class="" href="<?php echo SITE_PATH; ?>/<?= $item->slug; ?>.html" title="<?php echo $item->title ?>"><?= $item->title; ?></a>
        </h2>
        <div class="col-lg-12 paddingleftright chitietprice">
            <span style="font-weight: bold;">
                Price :
            </span><?= formatprice($item->price, Yii::$app->session->get('notation')); ?> 
            .<?= Yii::$app->session->get('notation'); ?>
        </div>
        <div class="col-lg-12 paddingleftright">
            <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynow', 'id' => $item->id])]); ?>            
            <div class="col-lg-2 col-md-3 col-sm-5 col-xs-6 paddingleftright">
                <?= $form->field($addToCartForm, 'count')->textInput(['maxlength' => 255, 'style' => 'height:25px;'])->label(false); ?>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-7 col-xs-6">
                <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black', 'style' => 'margin-top:0px;']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col-lg-12 paddingleftright">
        <?= $item->description ?>
    </div>
    <div class="col-lg-12 paddingleftright ortherproduct">
        <h3 style="padding-left:0px;padding-right:0px; margin-top:0px;">
            Sản phẩm cùng loại
        </h3>
        <?php
        $id = $item->category_id;
        $item = Catalog::last1(20, ['category_id' => $id], $item->id);
        if (count($item) > 0) {
            foreach ($item as $it) {
                ?>
                <?php if ($qua == 0) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 paddingleftright ortherproductone">
                        <div class="col-lg-12">				
                            <a class="bg-warning" href="<?php echo SITE_PATH ?>/<?= $it->slug ?>.html" title="<?= $it->title ?>">
                                <img src="<?php echo SITE_PATH . $it->image; ?>" alt="<?= $it->title ?>" title="<?= $it->title ?>" />				
                            </a>
                        </div>      
                        <div class="col-lg-12">
                            <a class="bg-warning" href="<?php echo SITE_PATH ?>/<?= $it->slug ?>.html" title="<?= $it->title ?>">
                                <?= $it->title ?>
                            </a>                
                        </div>
                        <div class="col-lg-12">
                            <a class="bg-info"><?= formatprice($it->price, Yii::$app->session->get('notation')); ?> .<?= Yii::$app->session->get('notation'); ?></a>
                        </div>
                        <div class="col-lg-12">
                            <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynow', 'id' => $it->id])]); ?>            
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 paddingleftright">
                                <?= $form->field($addToCartForm, 'count')->textInput(['maxlength' => 255, 'style' => 'height:25px; padding:2px 0px 2px 3px;'])->label(false); ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black', 'style' => 'margin-top:0px;']) ?>
                            </div>                    
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <!-- end the -->
                <?php } else { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">				
                        <div class="col-xs-12 paddingleftright">
                            <a class="bg-warning" href="<?php echo SITE_PATH ?>/<?= $it->slug ?>.html" title="<?= $it->title ?>">
                                <img style="width: 100%; border:1px solid #e3e3e3;" src="<?php echo SITE_PATH . $it->image; ?>" alt="<?= $it->title ?>" title="<?= $it->title ?>" />		
                            </a>
                        </div> 
                        <div class="col-xs-12 paddingleftright" style="text-align: center; padding-top: 5px; padding-bottom: 5px;">
                            <span style="color: #e55c19; font-size: 16px;">
                                <?= formatprice($it->price, Yii::$app->session->get('notation')); ?> <?= Yii::$app->session->get('notation'); ?>
                            </span>
                        </div>
                        <div class="col-xs-12">
                            <a style="" href="<?php echo SITE_PATH ?>/<?= $it->slug ?>.html" title="<?= $it->title ?>">
                                <?= $it->title; ?>
                            </a>
                        </div>
                        <div class="col-xs-12 paddingleftright">
                            <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynow', 'id' => $it->id])]); ?>           
                            <?php //echo $form->field($addToCartForm, 'count')->textInput(['maxlength' => 255, 'style' => 'height:25px; padding:2px 0px 2px 3px;'])->label(false);    ?>
                            <?php echo $form->field($addToCartForm, 'count')->hiddenInput(['value' => 1])->label(false); ?>
                            <div class="col-xs-12 minisubmit" style="text-align: center;">
                                <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black', 'style' => 'margin-top:0px;']) ?>
                            </div>                    
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                <?php } ?>

                <?php
            }
        }
        ?>
    </div>
</div>
