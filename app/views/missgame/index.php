<?php
use yii\easyii\modules\news\api\News;
use yii\easyii\modules\totalvote\models\Totalvote;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use amnah\yii2\user\models\User;
$page = Page::get('page-news');
$asset = app\assets\AppAsset::register($this);
$this->title = "Miss game 2016";
$this->params['breadcrumbs'][] = $page->model->title;
?>
<style>
p.row_miss{ margin-bottom: 0px;}
.row_miss a{
    color: #e55c19;
    font-weight: bold;
    text-decoration: none;
}
.row_miss a:hover{
    text-decoration: underline;
}
</style>
<div style="border:1px solid #b6b6b6; border-radius:8px 5px 5px 5px; margin-bottom: 10px;position: relative;">
    <div style="text-transform: uppercase;color: #fff; height: 28px;width: 200px;font-size: 12px; line-height: 27px;padding-left: 10px; position: absolute; top: 0px;left: 0px;background:url('<?php echo $asset->baseUrl; ?>/images/bg_khuyenmai1.png') no-repeat;">
        Miss game 2016
    </div>    
    <div style="border:2px solid #ececec; border-radius:5px; padding:0px 0px 20px 0px;">        
        <?php 
        $i=1;
        foreach($news as $item) : ?>    
        <style>
            .divload<?= $item->id;?>{ background: url('<?php echo $asset->baseUrl;?>/images/loading.gif') no-repeat #fff; position: absolute; top:1px; left:81px; height:16px; width:16px; }
        </style>
        <div class="row-news" style="<?php if($i==1){?> padding-top: 20px; <?php }?>">
            <div class="col-xs-3" style="padding: 15px 0px; text-align: center;">     
                <img style="width: 160px; height: 120px; border:1px solid #ccc; padding:2px;" src="<?php echo SITE_PATH;?><?php echo $item->image;?>" />
                <p class="row_miss">
                    <a href="<?php echo SITE_PATH?>/miss-game/<?php echo $item->slug;?>">
                        <?php echo $item->title;?>
                    </a>
                </p>
                <div style="position: relative;">
                    <i style="color:#a2d746;" class="glyphicon glyphicon-heart"></i>
                    <div class="divload<?= $item->id;?>" style="display: none;">&nbsp;</div>
                    <span id="luot<?= $item->id;?>">
                         <?php $t= Totalvote::getCount($item->id);echo $t;?> 
                    </span>
                    lượt
                </div>
                <!--<p>
                    <input id="buttonvote" onclick="VoteClick('<?php echo $item->id;?>',this)" type="button" value="Bình chọn" style="padding:3px 15px;" />
                </p>-->
            </div>       
            <div class="cl"></div>
        </div>
        <?php $i++;?>    
        <?php endforeach; ?>
        <?= News::pages() ?>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">    
    function VoteClick(code,myRadio) {  
        <?php
        $checkuser_face=  User::CheckUserFace();
            if($checkuser_face){  ?>  
        $(".divload"+code).css("display","block");
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
              $(".divload"+code).css("display","none"); 
           }
        });
        <?php   }else{?>
               alert("Login bằng facebook để bình chọn.");
        <?php }?>
    }
</script>