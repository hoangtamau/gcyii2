<?php

use yii\easyii\modules\page\api\Page;
use yii\easyii\modules\shopcart\api\Shopcart;
use yii\easyii\modules\catalog\api\Catalog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\modules\catalog\models\Item;
$asset= app\assets\AppAsset::register($this);
$page = Page::get('page-shopcart');
$this->title = "Thanh toán";
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
    Thanh toán
</h3>
<style>
.field-order-name label{ width:80px !important; float:left; margin-top:4px;}
.field-order-name input[type='text']{ width:70% !important;}

.field-order-address label{ width:80px !important; float:left; margin-top:4px;}
.field-order-address input[type='text']{ width:70% !important;}

.field-order-email label{ width:80px !important; float:left; margin-top:4px;}
.field-order-email input[type='text']{ width:70% !important;}

.field-order-phone label{ width:80px !important; float:left; margin-top:4px;}
.field-order-phone input[type='text']{ width:70% !important;}

.field-order-city label{ width:80px !important; float:left; margin-top:4px;}
.field-order-city input[type='text']{ width:70% !important;}

.field-order-country label{ width:80px !important; float:left; margin-top:4px;}
.field-order-country input[type='text']{ width:70% !important;}

.field-order-zipcode label{ width:80px !important; float:left; margin-top:4px;}
.field-order-zipcode input[type='text']{ width:70% !important;}

.field-delivery-delivery_name label{ width:130px !important; float:left; margin-top:4px;}
.field-delivery-delivery_name input[type='text']{ width:70% !important;}

.field-delivery-delivery_phone label{ width:130px !important; float:left; margin-top:4px;}
.field-delivery-delivery_phone input[type='text']{ width:70% !important;}

.field-delivery-delivery_address label{ width:130px !important; float:left; margin-top:4px;}
.field-delivery-delivery_address input[type='text']{ width:70% !important;}

.field-delivery-delivery_message label{ width:130px !important; float:left; margin-top:4px;}
#delivery-delivery_message{ width:70% !important;}

.field-delivery-delivery_date label{ width:130px !important; float:left; margin-top:4px;}
.field-delivery-delivery_date input[type='text']{ width:100% !important;}
.input-group-addon{padding: 5px 12px !important;}


</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom minishopcart" id="gototopshop">
    <?php if ($flash = Yii::$app->session->getFlash("Order-danger")): ?>
            <div class="alert alert-danger"><p><?= $flash ?></p></div>
    <?php endif; ?>
    <?php if ($total>0) : ?>
    <div class="col-lg-12 paddingleftright titleshopcart">
        <div class="col-lg-4 col-md-3 col-sm-4 col-xs-4 minishopcartitem">Item</div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 paddingleftright">Quantity</div>
        <div class="col-lg-2 col-md-2 hidden-sm hidden-xs paddingleftright">Price</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">Total</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 minishopcartr">Remove</div>
        <div class="clearfix">&nbsp;</div>
    </div>
    <?php foreach ($products as $product) : ?>
        <?php
            $quantity = $product->getQuantity()
        ?>
	<style>
        .divload<?= $product->id;?>{ background: url('<?php echo $asset->baseUrl;?>/images/24.gif') no-repeat; position: absolute; top:1px; left:8px; height:24px; width:24px; display:none;}
    </style>
    <div class="col-lg-12 paddingleftright rowshopcart beforeshopcart" id="cart<?= $product->id;?>">
        <div class="col-lg-4 col-md-3 col-sm-4 col-xs-4 minishopcartitem">
            <img alt="<?= $product->title;?>" class="hidden-sm hidden-xs" width="90px" title="<?= $product->title;?>" src="<?= SITE_PATH . $product->image ?>">
            <a href="<?php echo SITE_PATH."/".$product->slug?>.html" title="<?php echo $product->title;?>">
				<?php echo $product->title;?>
			</a>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 paddingleftright">
			<div style="width:25px; float: left;">
                <input id="buttondesc<?= $product->id;?>" style="width:25px; height: 25px;" type="button" onclick="Updatedesc(<?= $product->id?>)" value="-">
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 paddingleftright" style="position: relative;width:38px; text-align: center; float: left; padding-top:3px;">
                <div class="divload<?= $product->id;?>">&nbsp;</div>
                <span id="soluong<?= $product->id;?>"><?php echo $quantity?></span>
            </div>
            <div style="width:25px; float: left;">
                <input id="buttonasc<?= $product->id;?>" style="width:25px; height: 25px;" type="button" onclick="Updateasc(<?= $product->id?>)" value="+">
            </div>
            <div class="clearfix"></div>
		</div>
        <div class="col-lg-2 col-md-2 hidden-sm hidden-xs paddingleftright">
            <?= formatprice($product->price, Yii::$app->session->get('notation')); ?>
            <?php echo Yii::$app->session->get('notation'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingleftright">
			<span id="subtotal<?= $product->id;?>"><?= formatprice($product->price * $quantity, Yii::$app->session->get('notation')); ?></span>
            <?php echo Yii::$app->session->get('notation');?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 minishopcartr">
			<span style="color:red; cursor: pointer;" id="remove" onclick="Removecart(<?= $product->id?>)" class="glyphicon glyphicon-trash">&nbsp;</span>
        </div>
        <div class="clearfix">&nbsp;</div>
    </div>    
    <?php endforeach; ?>
    <div class="col-lg-12 paddingleftright rowshopcartlast">
        <h3>
            Total: 
            <span id="total"><?= formatprice($total, Yii::$app->session->get('notation'));?></span>
            <?php echo Yii::$app->session->get('notation') ?>
        </h3>
    </div>
    <div style="height: 40px; clear: both;">&nbsp;</div>
        <div class="send-shop">
            <?= Shopcart::form(['successUrl' => Url::to('/shopcart/success')]) ?>
        </div>       
    <?php else : ?>
        <p style="padding-left: 10px; color: red; min-height: 300px; font-size: 16px;"><strong>Shopping cart is empty</strong></p>
    <?php endif; ?>
</div>
<div class="clearfix">&nbsp;</div>
<style>
    h4.chonmenhgia{
        background: url('<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png') no-repeat;
        padding-left:15px;
    }
    .menu_san_pham_khac ul.men{ list-style: none; margin: 0px; padding:0px;}
    .menu_san_pham_khac ul.men li h5{
        background: url('<?php echo $asset->baseUrl;?>/images/men.png') repeat-x;
        height:27px; line-height:26px; color:#fff; padding-left:10px; margin: 0px;
        border-bottom:2px solid #e3e3e3;
    }
    .menu_san_pham_khac ul.men1{ list-style: none; margin: 0px;padding:0px;}
    .menu_san_pham_khac ul.men1 p{ color:#917d7d; margin:0px; padding-left:15px; cursor: pointer;}
    .menu_san_pham_khac ul.men1 p:hover{ color:#4d87c7; text-decoration: underline;}
    .menu_san_pham_khac ul.men1 li{ background:#d9d9d9; border-bottom:2px solid #e3e3e3; height:30px; line-height:25px;}
    
</style>
<div class="col-xs-12 paddingleftright">
    <div class="col-lg-3 menu_san_pham_khac" style="padding-left:0px !important;">        
        <h4 class="chonmenhgia">Mua thêm sản phẩm khác</h4>
        <ul class="men">
            <?php
            $cata=  Catalog::cats();
            $i=0;
            foreach ($cata as $c){                    
            if($c->depth==0&&$c->category_id!=71&&$c->category_id!=92){ // cap 1                        
            ?>
            <li>
                <h5><?php echo $c->title;?></h5>
                <ul class="men1">
                    <?php
                        $catas=  Catalog::cats1($c->category_id);
                        foreach ($catas as $cs){                                  
                    ?>
                    <li onclick="Loadspk(<?php echo $cs['category_id'];?>)">
                        <p><?php echo $cs['title'];?></p>
                    </li>
                    <?php }?>
                </ul>
            </li>
            <?php $i++;}}?>
        </ul>
    </div>
    <div class="col-lg-9 paddingleftright">
        <h4 class="chonmenhgia">Chọn thêm mệnh giá khác</h4>
        <div class="col-xs-12 paddingleftright" id="loadsanphamkhac" style="border:2px solid #e3e3e3; border-radius:5px; padding:20px !important;">
            <?php 
                $item = Catalog::ItemCatogory(47);
                if(count($item)>0){ 
                foreach ($item as $it){  
            ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 paddingleftright product">
                <div class="col-xs-12 paddingleftright" style="text-align: center;">
                    <img style="cursor: pointer;" onclick="Addshopcart(<?php echo $it->item_id;?>)" src="<?php echo SITE_PATH.$it->image;?>" alt="<?= $it->title ?>" />
                </div>  
            </div>
            <?php }}?>
        </div>
    </div><!-- end div col 9 -->
</div>

<script>
	function Loadspk(id){         
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/the/loadspk' ?>',
            type: 'post',
            data: {id: id},
            success: function (data) {
                $('#loadsanphamkhac').html(""+data+"");              
           }
        });      
    }
	
    function Addshopcart(id){        
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/shopcart/addshopcart' ?>',
            type: 'post',
            data: {id: id},
            success: function (data) {
				//alert(data);
				var str=data;
				var res = str.split("::"); 
				if(res[5]=="update"){
					$('#itemnumber').html("<span id='itemnumber' style='color:#4d87c7; font-weight:bold'>"+res[0]+"</span>");
					$('#itemprice').html("<span id='itemprice' style='color:#4d87c7; font-weight:bold'>"+res[1]+"</span>");
					$('#total').html("<span id='total'>"+res[2]+"</span>");
					$('#soluong'+id).html("<span id='soluong"+id+"'>"+res[3]+"</span>");
					$('#subtotal'+id).html("<span id='subtotal"+id+"'>"+res[4]+"</span>");
				}else{
					$('#itemnumber').html("<span id='itemnumber' style='color:#4d87c7; font-weight:bold'>"+res[0]+"</span>");
					$('#itemprice').html("<span id='itemprice' style='color:#4d87c7; font-weight:bold'>"+res[1]+"</span>");
					$('#total').html("<span id='total'>"+res[2]+"</span>");
					$('.rowshopcart:last').after(""+res[5]+"");
					$('.rowshopcart:last').before("<style>.divload"+id+"{ background: url('<?php echo $asset->baseUrl;?>/images/24.gif') no-repeat; position: absolute; top:1px; left:8px; height:24px; width:24px; display:none;}</style>");
					if(res[6]=="yeszing1"){
						$('.field-order-sale_currency').after('<div id="order_zing_id" class="form-group field-order-order_zing_id"><label class="control-label" for="order-order_zing_id"><span style="color:red;">ID zing</span></label><input type="text" id="order-order_zing_id" class="form-control" name="Order[order_zing_id]" placeholder="ID zing ..."><div class="help-block"></div></div>');
					}
					if(res[7]=="yeslink1"){
						$('.field-order-sale_currency').after('<div id="link_do_gl" class="form-group"><label class="control-label"><span style="color:red;">Email tại gamelink</span></label><input type="text" class="form-control" name="Order[linkdo]" placeholder="Email tại gamelink ..."></div>');
					}
				}
				document.getElementById('gototopshop').scrollIntoView();
		   }
        });            
    }
    function Removecart(id){         
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/shopcart/removecart' ?>',
            type: 'post',
            data: {id: id},
            success: function (data) {
			  var str=data;
              var res = str.split(":"); 
              $('#itemnumber').html("<span id='itemnumber' style='color:#4d87c7; font-weight:bold'>"+res[0]+"</span>");
              $('#itemprice').html("<span id='itemprice' style='color:#4d87c7; font-weight:bold'>"+res[1]+"</span>");
              $('#total').html("<span id='total'>"+res[2]+"</span>");
			  if(res[4]=="noquatang"){
                    $('#quatang').html("");
                }
                if(res[3]=="nozing"){
					$('#order_zing_id').html("");
				}
				if(res[5]=="nolink"){
					$('#link_do_gl').html("");
				}
           }
        });
        document.getElementById("cart"+id).remove();          
    }
    function Updateasc(id){
        $(".divload"+id).css("display","block"); 
        document.getElementById("buttondesc"+id).disabled = true;
        document.getElementById("buttonasc"+id).disabled = true;
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/shopcart/updateasc' ?>',
            type: 'post',
            data: {id: id},
            success: function (data) {
              //alert(data);
              var str=data;
              var res = str.split(":"); 
              $('#itemnumber').html("<span id='itemnumber' style='color:#4d87c7; font-weight:bold'>"+res[0]+"</span>");
              $('#itemprice').html("<span id='itemprice' style='color:#4d87c7; font-weight:bold'>"+res[1]+"</span>");
              $('#total').html("<span id='total'>"+res[2]+"</span>");
              $('#soluong'+id).html("<span id='soluong"+id+"'>"+res[3]+"</span>");
              $('#subtotal'+id).html("<span id='subtotal"+id+"'>"+res[4]+"</span>");
              $(".divload"+id).css("display","none"); 
              $('#buttonasc'+id).removeAttr("disabled");
              $('#buttondesc'+id).removeAttr("disabled");
           }
        });            
    }
    function Updatedesc(id){
        $(".divload"+id).css("display","block"); 
        document.getElementById("buttondesc"+id).disabled = true;
        document.getElementById("buttonasc"+id).disabled = true;
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/shopcart/updatedesc' ?>',
            type: 'post',
            data: {id: id},
            success: function (data) {
              var str=data;
              var res = str.split(":"); 
              if(res[5]=="noremove"){
                  $('#itemnumber').html("<span id='itemnumber' style='color:#4d87c7; font-weight:bold'>"+res[0]+"</span>");
                  $('#itemprice').html("<span id='itemprice' style='color:#4d87c7; font-weight:bold'>"+res[1]+"</span>");
                  $('#total').html("<span id='total'>"+res[2]+"</span>");
                  $('#soluong'+id).html("<span id='soluong"+id+"'>"+res[3]+"</span>");
                  $('#subtotal'+id).html("<span id='subtotal"+id+"'>"+res[4]+"</span>");
                  $(".divload"+id).css("display","none"); 
                  $('#buttonasc'+id).removeAttr("disabled");
                  $('#buttondesc'+id).removeAttr("disabled");
              }else{
                  $('#itemnumber').html("<span id='itemnumber' style='color:#4d87c7; font-weight:bold'>"+res[0]+"</span>");
                  $('#itemprice').html("<span id='itemprice' style='color:#4d87c7; font-weight:bold'>"+res[1]+"</span>");
                  $('#total').html("<span id='total'>"+res[2]+"</span>");
                  document.getElementById("cart"+id).remove();
				  if(res[6]=="nozing"){
					  $('#order_zing_id').html("");
					//document.getElementById("order_zing_id").remove();
					//document.getElementById("errorzingid").remove();
				  }
				  if(res[7]=="nolink"){
					  $('#link_do_gl').html("");
					//document.getElementById("order_zing_id").remove();
					//document.getElementById("errorzingid").remove();
				  }
              }
           }
        });            
    }
</script>