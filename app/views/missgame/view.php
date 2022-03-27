<?php
use yii\easyii\modules\news\api\News;
use yii\helpers\Url;
use yii\easyii\modules\totalvote\models\Totalvote;
$asset = app\assets\AppAsset::register($this);
$this->title = $news->seo('title', $news->model->title);

?>
<style>
    .misschitiet img{ max-width: 100%;}
    .divload{ background: url('<?php echo $asset->baseUrl;?>/images/loading.gif') no-repeat #fff; position: absolute; top:1px; left:351px; height:16px; width:16px; }
</style>
<div style="border:1px solid #b6b6b6; border-radius:8px 5px 5px 5px; margin-bottom: 10px;position: relative;">
    <div style="text-transform: uppercase;color: #fff; height: 28px;width: 200px;font-size: 12px; line-height: 27px;padding-left: 10px; position: absolute; top: 0px;left: 0px;">
        Miss game 2016
    </div>    
    <div style="border:2px solid #ececec; border-radius:5px; padding:10px">        
        <h2 style="margin: 0px; padding-bottom: 20px; padding-top: 10px; text-align: center;">
            <?= $news->seo('h1', $news->title) ?>
        </h2>
		<div class="misschitiet">
            <?= $news->text ?>
        </div>
        <div class="missinfo" style="text-align: center;">            
            <div style="position: relative; margin: 10px 0px;">
                <i style="color:#a2d746;" class="glyphicon glyphicon-heart"></i>
                <div class="divload" style="display: none;">&nbsp;</div>
                <span id="luot<?= $news->id;?>">
                     <?php $t= Totalvote::getCount($news->id);echo $t;?> 
                </span>
                lượt
            </div>
            <p>
                <input id="buttonvote" onclick="VoteClick('<?php echo $news->id;?>',this)" type="button" value="Bình chọn" style="padding:3px 15px;" />
            </p>
        </div>
        
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">    
    function VoteClick(code,myRadio) {  
        $(".divload").css("display","block");
        $.ajax({
           url: '<?php echo Yii::$app->request->baseUrl. '/site/xulybinhchon' ?>',
           type: 'post',
           data: {code: code},
           success: function (data) {
              var str=data.replace(/"/g, '');
              var res = str.split(":");
              if(res[0] == 'false'){
                  alert("Đăng nhập trước khi bình chọn.");
              }
              if(res[0] == 'false1'){
                  alert("Lổi trong quá trình bình chọn.");
              }
              if(res[0] == 'false2'){
                  alert("Mỗi thí sinh bạn chỉ được bình chọn 1 lần");
              }
              if(res[0] == 'false3'){
                  alert("Đăng nhập bằng facebook để bình chọn");
              }
              if(res[0] == 'true'){
                  $('#luot'+code).html("<span id='luot"+code+"'>"+res[1]+"</span>");
                  alert("Bình chọn thành công.");
              }
              $(".divload").css("display","none"); 
           }
        });
    }
</script>





