<?php 
$asset= app\assets\AppAsset::register($this);
$session = Yii::$app->session;
?>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" />
    Checkout complete
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <?php echo "<p style='color: red; font-size: 14px;;'>".Yii::$app->session->getFlash("successrepay")."</p>";?>
</div>