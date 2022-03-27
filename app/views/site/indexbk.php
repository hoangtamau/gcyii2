<?php

use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\file\api\File;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use app\models\AddToCartForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\modules\article\api\Article;
use yii\easyii\modules\catalog\models\Item;
use yii\easyii\modules\catalog\models\Category;


$session = Yii::$app->session;
$asset = app\assets\AppAsset::register($this);
$this->title = "Mua thẻ game online giá cực sock | Gamecard.vn";
$cata = Catalog::cats();
?>
<style>
    .one_product_h3 a{color:#fff; text-decoration: none; }
    .h3lienhe{   border-bottom: 1px solid #333; padding-bottom: 5px; font-size: 22px; margin-bottom: 15px;}
    .h3lienhe .quatang{font-size:16px; margin-top:9px; }
    .h3lienhe .quatang a{ text-decoration:none;}
    .margin0{margin:0px;}
    .divquatang .one_product_h3 a{color:#fff; text-decoration: none;}

</style>
<div class="col-xs-12 paddingleftright">
    <?php
   
    foreach ($cata as $cs) {
        if ($cs->category_id == 47 || $cs->category_id == 24 || $cs->category_id == 25 || $cs->category_id == 68 || $cs->category_id == 28 || $cs->category_id == 87 || $cs->category_id == 86 || $cs->category_id == 84 || $cs->category_id == 27 || $cs->category_id == 32 || $cs->category_id == 63 || $cs->category_id == 31) {
            if ($cs->depth == 1) {      // cap 1  		
                ?>
                <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynowhome'])]); ?> 
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 divproductnew paddingleftright">
                    <?php
                    if ($cs->category_id == 84 || $cs->category_id == 24 || $cs->category_id == 25 || $cs->category_id == 68 || $cs->category_id == 27 || $cs->category_id == 31 || $cs->category_id == 32 || $cs->category_id == 63) {
                        ?>
                        <h2 class="one_product_h3" title="<?php echo $cs->title; ?>">
                            <img src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" alt="<?php echo $cs->title; ?>" title="<?php echo $cs->title; ?>" />
                            <a href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>"><?php echo $cs->title; ?></a>
                        </h2> 
                    <?php } else { ?>
                        <h3 class="one_product_h3" title="<?php echo $cs->title; ?>">
                            <img src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" alt="<?php echo $cs->title; ?>" title="<?php echo $cs->title; ?>" />
                            <a  href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>"><?php echo $cs->title; ?></a>
                        </h3> 
                    <?php } ?>
                    <div class="col-xs-12 productnew paddingleftright">
                        <div class="col-lg-5 col-md-4 col-sm-5 col-xs-5 productimg paddingleftright">
                            <a href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>" title="<?php echo $cs->title; ?>">
                                <img src="<?php echo SITE_PATH; ?><?php echo $cs->image; ?>" title="<?php echo $cs->title ?>" alt="<?php
                                if ($cs->category_id == 24 || $cs->category_id == 24 || $cs->category_id == 25 || $cs->category_id == 68 || $cs->category_id == 28 || $cs->category_id == 27) {
                                    echo "Thẻ " . $cs->title;
                                } else {
                                    echo $cs->title;
                                }
                                ?>" />
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-8 col-sm-7 col-xs-7 productin">
                            <p>
                                <select name="id_product" class="selectprice">
                                    <option value="0"> Mệnh giá </option>
                                    <?php
                                    $item = Catalog::last(20, ['category_id' => $cs->category_id]);
                                    foreach ($item as $it) {
                                        ?>
                                        <option value="<?php echo $it->id; ?>">
                                            <?php echo $it->title; ?> (<?= formatprice($it->price, Yii::$app->session->get('notation')); ?> <?= Yii::$app->session->get('notation'); ?>) 
                                        </option>
                                    <?php } ?>
                                </select>
                            </p>
                            <p class="sl clearfix">
                                Số lượng: <?= $form->field($addToCartForm, 'count')->textInput(['class' => 'inputsl', 'maxlength' => 255])->label(false); ?>   
                            </p>
                            <p class="clearfix margin0" >&nbsp;</p>
                            <p>
                                <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black']) ?>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>          
                <?php ActiveForm::end(); ?>    

                <?php
            }
        }
    }
    ?>


    <div class="clearfix"></div>

    <?php
   
    foreach ($cata as $cs) {
        if ($cs->status == 1) {
            if ($cs->category_id == 71) {
                ?>            
                <h3 class="h3lienhe" >
                    <span class="glyphicon glyphicon-forward"></span><?php echo $cs->title; ?>

                    <span class="pull-right quatang" ><a  href="http://gamecard.vn/lien-he.html">Vui lòng liên hệ nhân viên hỗ trợ để được tư vấn và xem thêm nhiều mẫu sản phẩm</a></span>
                </h3>
                <?php
            }
            if ($cs->category_id == 47 || $cs->category_id == 24 || $cs->category_id == 86 || $cs->category_id == 84 || $cs->category_id == 25 || $cs->category_id == 68 || $cs->category_id == 28 || $cs->category_id == 27 || $cs->category_id == 32 || $cs->category_id == 63 || $cs->category_id == 31 || $cs->category_id == 23 || $cs->category_id == 30 || $cs->category_id == 71 || $cs->category_id == 87) {
                
            } else {
                ?>

                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 divproductnew divquatang paddingleftright">
                    <h3 class="one_product_h3" title="<?php echo $cs->title; ?>">
                        <img src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" alt="<?php echo $cs->title; ?>" title="<?php echo $cs->title; ?>" />
                        <a  href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>.htm"><?php echo $cs->title; ?></a>
                    </h3>        
                    <div class="col-xs-12 productquatang paddingleftright">
                        <div class="col-xs-12 productquatangimg paddingleftright">
                            <a href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>.htm" title="<?php echo $cs->title; ?>">
                                <img src="<?php echo SITE_PATH; ?><?php echo $cs->image; ?>" alt="<?php echo $cs->title; ?>"  title="<?php echo $cs->title; ?>" />
                            </a>
                        </div>
                        <div class="col-xs-12 productquatangin">
                            <p>
                                <a  href="<?php echo SITE_PATH ?>/<?php echo $cs->slug ?>.htm">
                                    <input type="button" class="button-submit submitmore button_black">
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            }
        }
    }
    ?>    

</div>
