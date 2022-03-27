<?php
use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\file\api\File;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use app\models\AddToCartForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\modules\article\api\Article;
$asset= app\assets\AppAsset::register($this);
?>
<?php
    $i=1;
    $id= Catalog::cat($slug);    
    $catas=  Catalog::cats1($id->tree);
    $name= Catalog::getname($id->tree);
?>
<h3 class="titlethe" style="border-radius:3px; margin-bottom: 20px;">
   <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
   <?php echo $name;?>
</h3>
<?php $this->title = $name;?>
<?php    
    foreach ($catas as $cs){     
    $item =  Catalog::last(20,['category_id'=>$cs['category_id']]);
    if(count($item)>0){
    ?> 
    <?php $form = ActiveForm::begin(['action' => Url::to(['/shopcart/buynowhome'])]); ?> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 paddingleftright one_product">				
				<a href="<?php echo SITE_PATH;?>/category/<?php echo $cs['slug'];?>">
					<img style="width:100%;" src="<?php echo SITE_PATH;?><?php echo $cs['image'];?>" alt="<?php echo $cs['title'];?>" />				
				</a>
                <div class="col-xs-12 one_product_select">                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright styled-select">
                        <select name="id_product">
                            <?php
                            $item =  Catalog::last(20,['category_id'=>$cs['category_id']]);
                            foreach ($item as $it){ 
                            ?>
                            <option value="<?php echo $it->id;?>">
                                <?php echo $it->title;?> (<?= formatprice($it->price, Yii::$app->session->get('notation')); ?> <?= Yii::$app->session->get('notation');?>)
                            </option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-3 col-xs-4 paddingleftright">
                        <?= $form->field($addToCartForm, 'count')->textInput(['maxlength' => 255])->label(false); ?>                        
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-8 paddingleftright xsbuynow">
                        <?= Html::submitButton('Mua ngay', ['class' => 'button-submit submitbuynow button_black']) ?>
                    </div>
                    <div class="clearfix"></div>
                </div>                    
            </div>         
            <?php ActiveForm::end(); ?>
    <?php }?>
<?php }?>























