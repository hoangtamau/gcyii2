<?php
use yii\helpers\Html;
$asset= app\assets\AppAsset::register($this);
$this->title = "Gamecard.vn – Not Found Page";
?>
<script type="text/javascript">
    function Redirect()
    {
        window.location = "http://gamecard.vn";
    }
    setTimeout('Redirect(301)', 5000);
</script>
<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl;?>/images/icon-hinhmuiten-cacloaithe.png" alt="Gamecard" />
    Not Found Page
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <div class="news-detail" style="text-align:center;">
        <img style="padding-top:29px;padding-bottom:40px;" src="<?php echo $asset->baseUrl;?>/images/notfound.png" alt="Not Found Page" />
        <p>
			The above error occurred while the Web server was processing your request.
		</p>
		<p>
			Please contact us if you think this is a server error. Thank you.
		</p>
    </div>
    <div class="clearfix"></div>
</div>