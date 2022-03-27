<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\modules\doituyen\models\Doituyen;
use yii\widgets\ActiveForm;

$asset = app\assets\AppAsset::register($this);
$this->title = "Dự đoán tỷ số vòng chung kết EURO 2016 - GamecardVN";
$model = new yii\easyii\modules\dudoan\models\Dudoan();
?>
<?php if (Yii::$app->session->hasFlash('dudoan')) {?>            
    <?php echo "<p style='background:#eaeaea;color:red;border:1px solid #ccc;padding:20px;border-radius: 5px;margin-top: -10px;'>" . Yii::$app->session->getFlash("dudoan") . "</p>";?>
<?php }?>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />
    Dự đoán tỷ số vòng chung kết Euro 2016
</h3>
<style>
    .dudoan{
        text-align: center;
    }
    .dudoan img{
        max-width: 124px; height:83px;
        padding:2px;
    }
    .dudoantrannay{ 
        background: url(<?php echo $asset->baseUrl; ?>/images/bg_menu_active.png) repeat-x; 
        border:0px; border-radius:2px; text-transform: uppercase; 
        color:#333; font-weight:bold;        
        font-size: 11px; padding:7px 15px;        
    }
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <?php
    foreach ($trandau as $t) {
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 dudoan paddingleftright">        
            <div class="col-xs-12" style="padding-bottom: 50px; padding-top: 10px;">
                <div class="col-xs-6" style="text-align: center;">
                    <img src="<?php echo SITE_PATH; ?><?php echo Doituyen::getCo($t->doituyen_id1) ?>" alt="" /> 
                    <p style="font-weight: bold;"><?php echo Doituyen::getName($t->doituyen_id1) ?></p>
                </div>
                <div class="col-xs-6" style="text-align: center;">
                    <img src="<?php echo SITE_PATH; ?><?php echo Doituyen::getCo($t->doituyen_id2) ?>" alt="" />
                    <p style="font-weight: bold;"><?php echo Doituyen::getName($t->doituyen_id2) ?></p>
                </div>                
                <div style="text-align:center;" data-toggle="modal" data-target="#exampleModal<?=$t->trandau_id;?>" data-whatever="@mdo">
                    <input class="dudoantrannay" type="button" value="Dự đoán" >
                </div>
                <!-- popup-->
                <div class="modal fade" id="exampleModal<?=$t->trandau_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="min-width: 340px !important; overflow: hidden;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">
                                    Vui cùng Euro 2016 <br/>
                                    <span style="font-size:14px; color:#8aca3d;">Dự đoán tỷ số</span>
                                </h4>
                            </div>
                            <!-- modal-body -->
                            <div class="modal-body">
                                <div class="diemdanh" style="position: relative; width:340px; margin: 0px auto; overflow: hidden;">    
                                    <?php if (!isset(Yii::$app->users->id)) { ?>
                                        <div class="">        
                                            <div class="clearfix"></div>
                                            <p style="text-align: center; padding-top: 15px;">Đăng nhập trước khi điểm danh</p>
                                        </div>
                                    <?php } else { ?>       
                                        <div class="">        
                                            <div class="col-xs-6" style="text-align: center;">
                                                <img src="<?php echo SITE_PATH; ?><?php echo Doituyen::getCo($t->doituyen_id1) ?>" alt="" /> 
                                                <span style="font-weight: bold;"><?php echo Doituyen::getName($t->doituyen_id1) ?></span>
                                            </div>
                                            <div class="col-xs-6" style="text-align: center;">
                                                <img src="<?php echo SITE_PATH; ?><?php echo Doituyen::getCo($t->doituyen_id2) ?>" alt="" />
                                                <span style="font-weight: bold;"><?php echo Doituyen::getName($t->doituyen_id2) ?></span>
                                            </div>
                                                
                                                <?php $form = ActiveForm::begin(['action' => Url::to(['/dudoan/send', 'id' => $t->trandau_id])]); ?>            
                                            
                                            <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->users->id])->label(false); ?> 
                                            <?= $form->field($model, 'trandau_id')->hiddenInput(['value'=> $t->trandau_id])->label(false); ?> 
                                            <?= $form->field($model, 'doituyen_id1')->hiddenInput(['value'=> $t->doituyen_id1])->label(false); ?> 
                                            <?= $form->field($model, 'doituyen_id2')->hiddenInput(['value'=> $t->doituyen_id2])->label(false); ?> 
                                            
                                            <div class="col-xs-12" style="margin: 10px 0px;">
                                                <div class="col-xs-6" style="margin-top: -7px;">
                                                    <?= $form->field($model, 'banthang1')->textInput(['maxlength' => 255, 'style' => 'text-align: right; width: 80px; padding-right: 3px; border-radius:2px; border:1px solid #666;float:right'])->label(false); ?>
                                                </div>
                                                <div class="col-xs-6" style="margin-top: -7px;">
                                                    <?= $form->field($model, 'banthang2')->textInput(['maxlength' => 255, 'style' => 'width: 80px; padding-right: 3px; border-radius:2px; border:1px solid #666; float:left'])->label(false); ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-12" style="margin: 10px 0px;">
                                                <p>
                                                    Lượt dự đoán giống bạn: 
                                                    <?= $form->field($model, 'luotdudoangiongban')->textInput(['maxlength' => 255, 'style' => 'height:25px;'])->label(false); ?>
                                                </p>
                                            </div>                                            
                                            <div class="col-xs-12">
                                                <?= Html::submitButton('Gửi dự đoán', ['class' => 'btn btn-danger','style' => '']) ?>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end popup-->
                <div class="clearfix"></div>
            </div>  
        </div>
<?php } ?>
</div>

