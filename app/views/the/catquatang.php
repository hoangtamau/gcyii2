<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$asset= app\assets\AppAsset::register($this);
$this->title = $cat->seo('title', $cat->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Shop', 'url' => ['shop/index']];
$this->params['breadcrumbs'][] = $cat->model->title;
?>
<?php if($baiviet!=""){?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid #ccc; margin-bottom:20px; padding:15px; border-radius:2px;">
	<?php echo $baiviet;?>
	</div>
	<div class="clearfix"></div>
<?php }?>

<h3 style="border-bottom: 1px solid #333; padding-bottom: 5px; font-size: 14px; margin-bottom: 15px;">
    <span class="glyphicon glyphicon-forward"></span><?php echo $cat->title;?>
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftright">	
    <?php if(count($items)) : ?>
        <?php $i=1; ?>
        <?php foreach($items as $item) : ?>                
            <?= $this->render('_item_quatang', ['it' => $item,'i' => $i,'tong'=>count($items),'addToCartForm' =>$addToCartForm]) ?>                
        <?php $i++;?>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Category is empty</p>
    <?php endif; ?>
</div>