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

<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
    <?php echo $cat->title;?>
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">	
    <?php if(count($items)) : ?>
        <?php $i=1; ?>
        <?php foreach($items as $item) : ?>                
            <?= $this->render('_item', ['it' => $item,'i' => $i,'tong'=>count($items),'addToCartForm' =>$addToCartForm]) ?>                
        <?php $i++;?>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Category is empty</p>
    <?php endif; ?>
</div>