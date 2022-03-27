<style>
    #addtousermoneyform-payment_method{padding:5px;}
    #currency{display: block; padding: 5px; width:65px; float:left;}
    .field-addtousermoneyform-money,.field-addtousermoneyform-payment_method{ float:left; margin-right:5px;}
    #sapsi{display: block; padding: 5px 2px; color:red; }
</style>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use amnah\yii2\user\models\Zone;
use yii\easyii\helpers\Globals;
use yii\helpers\ArrayHelper;
use yii\easyii\modules\payment\models\Payment;
use yii\easyii\helpers\Onepay;
use yii\easyii\helpers\OnepayND;
use yii\easyii\helpers\Paypal;
use amnah\yii2\user\models\Addresses;
use yii\easyii\helpers\Mail;
use yii\easyii\models\Setting;

use app\modules\usermoney\models\UserMoney;
use app\modules\usermoney\models\AddToUserMoneyForm;
use app\modules\usermoney\models\UserHistoryMoney;

/* @var $this yii\web\View */
/* @var $model common\modules\product\models\Product */
/* @var $form yii\widgets\ActiveForm */
$asset= app\assets\AppAsset::register($this);
$session = Yii::$app->session;
$notation = $session->get('notation');
?>
<script type='text/javascript'>
    $(window).load(function(){
        $('input.number').keyup(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40){
            event.preventDefault();
            }
            $(this).val(function(index, value) {
            return value
            .replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
            });
        });
    });
</script>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
    Nạp tiền
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
<?php $form = ActiveForm::begin(['action' => Url::to(['/usermoney/usermoney/send'])]); ?>
<?php $address = Addresses::findOne(['uid' => Yii::$app->users->id]);?>
    <div style='margin-top:15px; margin-bottom:25px;' class='col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright'>
        <i style="font-weight: bold;"><?= $address->first_name.", ".$address->street1.", ".$address->city.", ".$address->country;?></i>
    </div>  
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright'>
    <?php echo $form->field($model, 'money')->textInput(
                array(
                    'placeholder' => 'Số tiền nạp ...',
                    'style'=>'padding:4px; border-radius:2px; border:1px solid #e4e4e4;',
                    'id'=>'money',
                    'class'=>'number',
                    'onchange' => '$.post( "' . Url::toRoute('/usermoney/usermoney/sapsi') . '", { id: document.getElementById("money").value } )
                        .done(function( data ) {   
                            d = document.getElementById("money").value;
                            $( "#sapsi" ).html(data);
                        }
                    );
                    '
                    )
                )->label(FALSE);  
    ?>
    <span style='display: block; padding: 5px 2px; width:40px; float:left;'><?php echo $notation;?></span>
    <span id='sapsi'>&nbsp;</span>
    </div>
    <div style='height:25px;'>&nbsp;</div>
    <?php
        $listDatapayment = Payment::GetpaymentNap($notation);
        $listcurrency = Payment::GetpaymentCurrency($notation);
    ?>
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright'>
        <?php
        echo $form->field($model, 'payment_method')->dropDownList($listDatapayment,
                    [
                        'onchange' => '$.post( "' . Url::toRoute('/usermoney/usermoney/getsalecurrency') . '", { id: document.getElementById("addtousermoneyform-payment_method").value } )
                                .done(function( data ) {                                
                                $( "#currency" ).html(data);
                                }
                            );
                        '
                    ]
                )->label(false);
        echo $form->field($model, 'currency_payment_method')->dropDownList($listcurrency,array('id'=>'currency','style'=>'clear:both;'))->label(false);        
        ?>
    </div>
    <div style='height: 13px; clear: both;border-bottom: 1px dotted #ccc;margin-bottom: 20px;'>&nbsp;</div>
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright'>
        <?php echo Html::submitButton(Yii::t('easyii', 'Nạp tiền'), ['class' => 'btn button_black btn-large btn-primary']); ?>
    </div> 
<?php ActiveForm::end(); ?>
</div>