<?php

use yii\easyii\modules\article\api\Article;
use yii\helpers\Url;
use yii\helpers\Html;

$asset = app\assets\AppAsset::register($this);
?>

<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" alt="Gamecard" />
    Chi tiết
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <div class="news-detail">
        <h1 style="margin: 0px; padding-bottom: 20px; padding-top: 10px; text-align: center; font-size:22px; font-weight:bold;">
            <?php
            echo $article->seo('h1', $article->title);
            $this->title = $title;
            ?>
        </h1>
        <div class="news-detail-content">
            <?php echo $article->text ?>
        </div>
    </div>
    <?php
    $item = \yii\easyii\modules\article\models\Item::find()->where('slug = "' . $article->slug . '"')->one();
    $id_cate = $article->category_id;
    $articlecategory = Article::ItemOrther($id_cate, $item->item_id);
    if (count($articlecategory) > 0) {
        ?>
        <div>
            <h4 class="tinlienquanarticles" >Tin liên quan</h4>
            <ul class="orther">
                <?php foreach ($articlecategory as $orther) { ?>			
                    <?php if (Yii::$app->session->get('notation') == 'VND' && ($orther->id_khuyenmai == 0 || $orther->id_khuyenmai == 1)) { ?>
                        <li> 
                            <a href="<?php echo SITE_PATH ?>/detail-news/<?php echo $orther->slug ?>" title="<?php echo $orther->title; ?>">
                                <?php echo $orther->title; ?>
                            </a>
                        </li>
                    <?php } ?>	
                    <?php if (Yii::$app->session->get('notation') != 'VND' && ($article->id_khuyenmai == 0 || $article->id_khuyenmai == 2)) { ?>
                        <li> 
                            <a href="<?php echo SITE_PATH ?>/detail-news/<?php echo $orther->slug ?>" title="<?php echo $orther->title; ?>">
                                <?php echo $orther->title; ?>
                            </a>
                        </li>
                    <?php } ?>	
                <?php } ?>
            </ul>        
        </div>
    <?php } ?>
    <div class="clearfix"></div>
</div>