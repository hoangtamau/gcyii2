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
$arraythegame = [87, 47, 24, 25, 27, 84, 68, 28, 32, 63, 31,90,91,93,97,99];
$arrayquatang = [95, 72, 73, 74, 94, 96, 83,88]; 
$html = '';
?>
<style>
    .one_product_h3 a{color:#fff; text-decoration: none; }
    .h3lienhe{   border-bottom: 1px solid #333; padding-bottom: 5px; font-size: 16px; margin-bottom: 15px;}
    .h3lienhe .quatang{font-size:12px; margin-top:3px; }
    .h3lienhe .quatang a{ text-decoration:none;}
    .margin0{margin:0px;}
    .divquatang .one_product_h3 a{color:#fff; text-decoration: none;}

</style>

<div class="col-xs-12 paddingleftright">
    <?php
    $i=0;
    foreach ($cata as $cs) {
        if (in_array($cs->category_id, $arraythegame)) {
            if ($cs->depth == 1 && $cs->status == 1) {
                ?>
                <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynowhome'])]); ?> 
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 divproductnew paddingleftright">

                    <h2 class="one_product_h3" title="<?php echo $cs->title; ?>">
                        <img src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" alt="<?php echo $cs->title; ?>" title="<?php echo $cs->title; ?>" />
                        <a href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>"><?php echo $cs->title; ?></a>
                    </h2> 

                    <div class="col-xs-12 productnew paddingleftright">
                        <div class="col-lg-5 col-md-4 col-sm-5 col-xs-5 productimg paddingleftright">
                            <a href="<?php echo SITE_PATH; ?>/<?php echo $cs->slug; ?>" title="<?php echo $cs->title; ?>">
                               <img src="<?php echo SITE_PATH; ?><?php echo $cs->image; ?>" title="<?php echo $cs->title ?>" alt="<?php
                                if ($cs->category_id == 24 || $cs->category_id == 25 || $cs->category_id == 68 || $cs->category_id == 28 || $cs->category_id == 27) {
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
                                Số lượng: <?= $form->field($addToCartForm, 'count',['inputOptions' => ['id' => 'myCustomId'.$i  ]  ])->textInput(['class' => 'inputsl', 'maxlength' => 255])->label(false); ?>   
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
        } else if (in_array($cs->category_id, $arrayquatang)) {
            if ($cs->depth == 1 && $cs->status == 1) {
                $html .= ' 

                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 divproductnew divquatang paddingleftright">
                    <h3 class="one_product_h3" title="' . $cs->title . '">
                        <img src="'.$asset->baseUrl.'/images/icon-hinhmuiten-cacloaithe.png" alt="' . $cs->title . '" title="' . $cs->title . '" />
                        <a  href="'.SITE_PATH.'/'.$cs->slug.'.htm">' . $cs->title . '</a>
                    </h3>        
                    <div class="col-xs-12 productquatang paddingleftright">
                        <div class="col-xs-12 productquatangimg paddingleftright">
                            <a href="'.SITE_PATH.'/'.$cs->slug.'.htm" title="' . $cs->title . '">
                                <img src="'.SITE_PATH.'/'. $cs->image.'" alt="' . $cs->title . '"  title="' . $cs->title . '" />
                            </a>
                        </div>
                        <div class="col-xs-12 productquatangin">
                            <p>
                                <a  href="' . SITE_PATH . '/' . $cs->slug . '.htm">
                                    <input type="button" class="button-submit submitmore button_black">
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>';
            }
        }
        $i++;
    }
    ?>
    <div class="clearfix"></div>
    <h3 class="h3lienhe">
        <span class="glyphicon glyphicon-forward"></span>Quà tặng online
        <span class="pull-right quatang" ><a  href="http://gamecard.vn/lien-he.html">Vui lòng liên hệ nhân viên hỗ trợ để được tư vấn và xem thêm nhiều mẫu sản phẩm</a></span>
    </h3>
    <?= $html ?>
</div>
