<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\payment\models\Payment;
use yii\easyii\helpers\Globals;
use app\modules\laythe\models\Order;
use amnah\yii2\user\models\Addresses;
use yii\easyii\models\Setting;
$asset= app\assets\AppAsset::register($this);
$this->title = "Mua thẻ";
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<style>
.submitnext{padding-left: 5px !important; padding-right: 5px !important; text-align: center; padding-top: 43px;}
.laythe-web select {width: 100%;}
.laythe-web input[type='text'] {width: 100%;}
.thanhtoan-web{padding:0px 10px;}
.thanhtoan-web th{color:#b62e2e; font-weight: bold;}
.table tr th{border-bottom: 1px dotted #ccc; padding-top: 3px; background-color: #e4e4e4; padding-left: 10px;}
.table tr td{border-bottom: 1px dotted #ccc; padding-top: 3px; padding-left: 10px;}
.send-shop input[type='text']{ padding:4px; width:220px;}
.send-shop label{display:inline-block; width: 80px;}
.modal-radio{ width: 100% !important;}
.send-shop h4{ margin: 20px 0px 10px 0px;}
.field-order-comment label{ vertical-align: top;}
.laythesl input,.laythett input{
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 2px;
    padding:5px;    
    width: 207px;
}
.laythesl{ margin-bottom: 8px;}
.sendlaythe{ margin-top: 20px; border-top: 1px dashed #e3e3e3;padding-top: 15px;}
.sendlaythe label{ width: 75px !important;}
.sendlaythe input[type="text"]{
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 2px;
    padding: 5px;    
    width: 100%;
}
.subnext{
    background: url('<?php echo $asset->baseUrl;?>/images/submitnext.png') no-repeat;
    text-indent: -99999px;
    
}
.muathetitle{background: #e3e3e3; height: 30px; line-height: 30px;}
.muatherow{ border-bottom:1px dotted #e3e3e3; min-height: 25px; padding-top:5px;}
</style>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
    Mua thẻ
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom laythe-web">
    <?php $form = ActiveForm::begin(['action' => Url::to(['/laythe1/laythe/add'])]); ?>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 paddingleftright">
            <div>
            <?php 
            $session = Yii::$app->session;        
            $notation = $session->get('notation');
            $listDatapayment = Payment::Getpayment($notation);
            $list=  Catalog::GetAll();
            $cata=  Catalog::GetAll1($notation);
            $cataid=  Catalog::GetIDOne($notation);
            $cataname=  Catalog::GetNameOne($notation);
            ?>            
                <?php echo $form->field($model, 'loai_laythe')->dropDownList($list,
                        [
                            'onchange' => '$.get( "'.Url::toRoute('/laythe1/laythe/thanhtien').'", { 
                                id: document.getElementById("addtolaytheform-loai_laythe").value,
                                sl: document.getElementById("sl").value
                                } )
                                    .done(function( data ) {                                         
                                        var res = data.split(":");
                                        $( ".laythett" ).html(res[0]);
                                        $( "#price" ).html(res[1]);
                                        $( "#idthe" ).html(res[2]);
                                        $( "#namethe" ).html(res[3]);
                                    }
                                );
                            '
                        ]
                    )->label(false);?>
            </div>
            <div id="idthe"><input type="hidden" value="<?= $cataid;?>" id="idthe1" /></div>
            <div id="namethe"><input type="hidden" value="<?= $cataname;?>" id="namethe1" /></div>
            <div id="price"><input type="hidden" value="<?php echo $cata;?>" id="hiddenprice" /></div>
            <div class="laythesl">
                <input type="text" id="sl" name="AddToLayTheForm[sl_laythe]" value="1" />
            </div>
            <div class="laythett">
                <?php echo "<input type='text' name='tt' value='".Globals::formatprice($cata)." ".$notation."' />";?>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 submitnext">
            <?php echo Html::submitButton(Yii::t('easyii', '->>'), ['class' => 'btn button_black btn-large btn-primary','style'=>'padding:3px 8px;']);?>
        </div>
        <?php ActiveForm::end(); ?>
    
    <?php
        $cart = \Yii::$app->cart;
        $products = $cart->getPositions();
        $total = $cart->getCost();
    ?>  
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 paddingleftright">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright muathetitle">
            <div class="col-lg-4 col-md-3 col-sm-4 col-xs-4 paddingleftright">
                Item
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 paddingleftright">
                Quantity
            </div>
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs paddingleftright">
                Price
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">
                Total
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">
                Remove
            </div>
            <div class="clearfix">&nbsp;</div>
        </div>
        <?php 
        foreach ($products as $product){
            $quantity = $product->getQuantity(); 
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright muatherow">
            <div class="col-lg-4 col-md-3 col-sm-4 col-xs-4 paddingleftright">
                <?php echo $product->title;?>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 paddingleftright">
                <?php echo $quantity;?>
            </div>
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs paddingleftright">
                <?php echo Globals::formatprice($product->price)." ".$notation;?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">
                <?php echo Globals::formatprice($product->price*$quantity)." ".$notation;?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">
                <?php 
                    echo Html::a('Remove', 
                    ['/laythe1/laythe/remove', 
                        'id' => $product->id
                    ], 
                    ['title' => 'Remove item', 
                        'style' => 'color:red;'
                    ]);
                ?>
            </div>
        </div>
        <?php }?>
        
        <div style="text-align:right;padding-right:10px; padding-top:7px;padding-bottom:7px;">
            Total: <?php echo Globals::formatprice($total).' '.$notation;?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php        
        $address = Addresses::findOne(['uid' => Yii::$app->users->id]);
        $session = Yii::$app->session;
        if ($address) {
            $modelor->name = $address->first_name;
            $modelor->address = $address->street1;
            $modelor->email = Yii::$app->users->email;
            $modelor->phone = $address->phone;
            $modelor->city = $address->city;
            $modelor->country = $address->country;
            $modelor->zipcode = $address->postal_code;
        } else {
            $modelor->email = Yii::$app->users->email;
            $country = $session->get('country');
            $modelor->city = $country->city;
            $modelor->zipcode = $country->zip;
            $modelor->country = $country->country;
        }
        $modelor->scenario = 'confirm';        
        $notation = $session->get('notation');
        $listDatapayment = Payment::Getpayment($notation);
        if($total>0){
        
        $form = ActiveForm::begin([
            'action' => Url::to(['/laythe1/laythe/index']),
            'options' => [
                    'style'=>''
                ]  
        ]);
        echo "<div class='sendlaythe'>";
        echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright'>";        
        echo $form->field($modelor, 'name');
        echo $form->field($modelor, 'email');
        echo $form->field($modelor, 'address');
        echo $form->field($modelor, 'phone');
        $listtypesubmit=array();
        $listtypesubmit[1]="Lấy thẻ";
        $listtypesubmit[2]="Đổi thẻ";
        echo $form->field($modelor, 'city')->textInput(['readonly' => true]);
        echo $form->field($modelor, 'country')->textInput(['readonly' => true]);
        echo $form->field($modelor, 'zipcode');
        echo "</div>";
        echo "<div>";
        echo $form->field($modelor, 'type_submit')->radioList($listtypesubmit)->label(false);
        echo "</div>";
        
            echo "<div style='margin-top:20px;'>";
            echo Html::submitButton(Yii::t('easyii', 'Mua ngay'), ['class' => 'btn button_black btn-large btn-primary']);
            echo "</div>";
        
        echo "<div class='cl'>&nbsp;</div>";
        echo "</div>";
        ActiveForm::end();        
        }
    ?>
</div>
