<?php

use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\file\api\File;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use app\models\AddToCartForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\helpers\Globals;
use yii\easyii\modules\article\api\Article;

$asset = app\assets\AppAsset::register($this);
?>
<?php
$i = 1;
$id = Catalog::cat($slug);
$catas = Catalog::cats1($id->tree);
$name = Catalog::getname($id->tree);
?>
<?php $this->title = $titlecategory; ?>
<style>
.catalogbaiviet h1,.catalogbaiviet h2,.catalogbaiviet h3,.catalogbaiviet h4,.catalogbaiviet h5,.catalogbaiviet h6{margin-bottom:0px !important; margin-top:0px !important;}
</style>
<?php if ($baiviet != "") { ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 catalogbaiviet" style="border:1px solid #ccc; margin-bottom:20px; padding:15px; border-radius:2px;">
        <?php echo $baiviet; ?>
    </div>
    <div class="clearfix"></div>
<?php } ?>

<?php
$urllink = Globals::getCurrentPageURL();
Yii::$app->session->setFlash("catalog", $urllink);

foreach ($catas as $cs) {
    if ($cs['status'] == 1) {
        $item = Catalog::last(20, ['category_id' => $cs['category_id']]);
        if (count($item) > 0) {
            ?> 
            <?php if (Yii::$app->session->get('notation') != "VND" || isset(Yii::$app->users->id)) { ?>
                <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynowhome'])]); ?> 
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 divproductnew paddingleftright">
                    <h3 class="one_product_h3" title="<?php echo $cs['title']; ?>">
                        <img alt="Gamecard" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />
                        <a style="color:#fff; text-decoration: none;" href="<?php echo SITE_PATH; ?>/<?php echo $cs['slug']; ?>">
                            <?php echo $cs['title']; ?>
                        </a>
                    </h3>        
                    <div class="col-xs-12 productnew paddingleftright">
                        <div class="col-lg-5 col-md-4 col-sm-5 col-xs-5 productimg paddingleftright">
                            <a href="<?php echo SITE_PATH; ?>/<?php echo $cs['slug']; ?>">
                                <img src="<?php echo SITE_PATH; ?><?php echo $cs['image']; ?>" alt="<?php echo $cs['title']; ?>" title="<?php echo $cs['title']; ?>" />
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-8 col-sm-7 col-xs-7 productin">
                            <p>
                                <select name="id_product" class="selectprice">
                                    <option value="0"> Mệnh giá </option>
                                    <?php
                                    $item = Catalog::last(20, ['category_id' => $cs['category_id']]);
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
                            <p class="clearfix" style="margin:0px;">&nbsp;</p>
                            <p>
                                <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black']) ?>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <?php ActiveForm::end(); ?>
            <?php } elseif ($cs['category_id'] != 68 && $cs['category_id'] != 85) { ?>
                <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynowhome'])]); ?> 
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 divproductnew paddingleftright">
                    <h3 class="one_product_h3" title="<?php echo $cs['title']; ?>">
                        <img alt="Gamecard" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />
                        <a style="color:#fff; text-decoration: none;" href="<?php echo SITE_PATH; ?>/<?php echo $cs['slug']; ?>">
                            <?php echo $cs['title']; ?>
                        </a>
                    </h3>        
                    <div class="col-xs-12 productnew paddingleftright">
                        <div class="col-lg-5 col-md-4 col-sm-5 col-xs-5 productimg paddingleftright">
                            <a href="<?php echo SITE_PATH; ?>/<?php echo $cs['slug']; ?>">
                                <img src="<?php echo SITE_PATH; ?><?php echo $cs['image']; ?>" alt="<?php echo $cs['title']; ?>" title="<?php echo $cs['title']; ?>" />
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-8 col-sm-7 col-xs-7 productin">
                            <p>
                                <select name="id_product" class="selectprice">
                                    <option value="0"> Mệnh giá </option>
                                    <?php
                                    $item = Catalog::last(20, ['category_id' => $cs['category_id']]);
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
                            <p class="clearfix" style="margin:0px;">&nbsp;</p>
                            <p>
                                <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black']) ?>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <?php ActiveForm::end(); ?>
            <?php } ?>
        <?php }// end item >0 ?>
    <?php }// end status  ?>
    <?php
}?>