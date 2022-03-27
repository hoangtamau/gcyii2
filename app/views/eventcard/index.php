<?php

use yii\widgets\ActiveForm;
use app\models\Eventorder;

$asset = app\assets\AppAsset::register($this);
$addeventorder = new \app\models\Eventorder();

use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\modules\page\api\Page;
use yii\easyii\modules\article\models\Item;

$asset = app\assets\AppAsset::register($this);
$this->title = "Event card - GamecardVN";
?>
<?php if (Yii::$app->session->hasFlash('successevent')) { ?>
	<?php echo "<p style='color:red;border:1px solid #ccc;padding:10px;border-radius: 5px;margin-top: -10px;'>" . Yii::$app->session->getFlash("successevent") . "</p>"; ?>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('faileevent')) { ?>
	<?php echo "<p style='color:red;border:1px solid #ccc;padding:10px;border-radius: 5px;margin-top: -10px;'>" . Yii::$app->session->getFlash("faileevent") . "</p>"; ?>
<?php } ?>		
<?php if (Yii::$app->session->hasFlash('timeevent')) { ?>
	<?php echo "<p style='color:red;border:1px solid #ccc;padding:10px;border-radius: 5px;margin-top: -10px;'>" . Yii::$app->session->getFlash("timeevent") . "</p>"; ?>
<?php } ?>
<div style="padding:10px; border:1px solid #e3e3e3; border-radius:3px; margin-bottom:20px;">
	<?php 
	$noteevent=Item::find()->where('item_id=173')->one();
	echo $noteevent['text'];
	?>
</div>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />
    Event card
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">    
        <?php foreach ($eventcard as $e) { ?>    
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 divproductnew divproductnew1 paddingleftright" style="margin-bottom: 35px; text-align: center;">                       
                <div class="col-xs-12 paddingleftright">
                    <div style="position: relative; padding-top: 35px; margin-bottom: 20px;">
                        <img style="width:180px; height:108px;" src="<?php echo SITE_PATH; ?><?php echo $e->image; ?>" />
                        <img class="imgeventpromotion" style="position: absolute; top:-20px; left: 35px; width: 85px;" src="<?php echo SITE_PATH; ?><?php echo $e->images; ?>" />
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $e->eventcard_id?>">
                        ĐẶT HÀNG NGAY
                    </button>
                    <?php $form = ActiveForm::begin([
                        'action' => Url::to(['/eventcard/buynow']),
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 paddingleftright\">{input}</div>\n<div class=\"col-lg-4 col-md-4 paddingleftright\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-3 col-md-3 control-label','style'=>'padding-top: 5px;'],
                        ],
                        ]); ?> 
                    <div class="modal fade" id="myModal<?php echo $e->eventcard_id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="position: relative; overflow: hidden;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Thông tin đặt hàng</h4>
                                </div>
                                <div class="modal-body">
                                    <?= $form->field($addeventorder, 'eventcard')->hiddenInput(['value' => $e->eventcard_id])->label(false); ?>
                                    <?= $form->field($addeventorder, 'namecard')->textInput(['readonly' => true, 'value' => $e->title,'maxlength' => 255, 'style' => 'height:30px; padding:2px 0px 2px 3px;']); ?>
                                </div>
                                <div class="modal-body">
                                    <?= $form->field($addeventorder, 'email')->textInput(['maxlength' => 255, 'style' => 'height:30px; padding:2px 0px 2px 3px;']); ?>
                                </div>
                                <div class="modal-body">
                                    <?= $form->field($addeventorder, 'phone')->textInput(['maxlength' => 25, 'style' => 'height:30px; padding:2px 0px 2px 3px;']); ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>                                    
                                    <?= Html::submitButton('Đặt hàng', ['class' => 'btn btn-primary btn-xs', 'style' => 'margin-top:0px;']) ?>
                                </div>
								<div style="position: absolute; top:0px; left: -25px;">
                                    <img style="width:110px;" src="<?php echo SITE_PATH; ?><?php echo $e->images; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php } ?>    
    <div class="clearfix"></div>
</div>
