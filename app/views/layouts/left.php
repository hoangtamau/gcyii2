<?php

use yii\helpers\Html;
use yii\easyii\modules\article\api\Article;

$asset = app\assets\AppAsset::register($this);

use yii\easyii\modules\catalog\api\Catalog;
use yii\easyii\modules\catalog\models\Category;
use yii\easyii\helpers\Data;
$session = Yii::$app->session;

$cata = Catalog::cats();
?>

<div class="navigation-menu clearfix menu">
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse-right2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="hidden-lg hidden-md hidden-sm navbar-brand">       
                    <h4 >Các loại thẻ</h4>
                </div>
            </div>
            <div class="navbar-collapse navbar-collapse-right2 collapse">
                <ul class="nav navbar-nav menu1">
                    <?php
                    $i = 0;
                    foreach ($cata as $c) {
                        if ($c->category_id != 71 && $c->category_id != 72 && $c->category_id != 73 && $c->category_id != 74 && $c->category_id != 92) {
                            if ($c->depth == 0) {
                                ?>
                                <li>
                                    <h4  class='line'><a class="athegame" href="<?php echo SITE_PATH; ?>/<?php echo $c->slug; ?>" title="<?php echo $c->title; ?>"><?php echo $c->title; ?></a></h4>
                                    <ul class="the-game-online" >
                                        <?php
                                        $catas = Catalog::cats1($c->category_id);
                                        foreach ($catas as $cs) {
                                            ?>
                                            <li class='line'>									
                                                <a class="a_menu" href="<?php echo SITE_PATH; ?>/<?php echo $cs['slug']; ?>" title="<?php echo $cs['title']; ?>"><?php echo $cs['title']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php
                                $i++;
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<style>
    .class1{border-top: 1px dotted #aaabab;}
</style>
<div class="menu hidden-xs">
    <h3><img  class="cacloaithe"  src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" title="các loại thẻ" alt="Gamecard" />Các loại thẻ</h3>
    <div id='menu_box'>
        <ul class='menu1'>
            <?php
            $i = 0;
            foreach ($cata as $c) {
                if ($c->category_id != 71 && $c->category_id != 72 && $c->category_id != 73 && $c->category_id != 74 && $c->category_id != 92) {
                    if ($c->depth == 0) {
                        ?>
                        <li>
                            <h4  class='line'><a class="a-the-game-online"  href="<?php echo SITE_PATH; ?>/<?php echo $c->slug; ?>" title="<?php echo $c->title; ?>"><?php echo $c->title; ?></a></h4>
                            <ul class="the-game-online" >
                                <?php
                                $catas = Catalog::cats1($c->category_id);
                                foreach ($catas as $cs) {
                                    ?>
                                    <li class='line'>					
                                        <a class="a_menu" href="<?php echo SITE_PATH; ?>/<?php echo $cs['slug']; ?>" title="<?php echo $cs['title']; ?>"><?php echo $cs['title']; ?></a>
                                    </li>					
                                <?php } ?>
                            </ul>
                        </li>
                        <?php
                        $i++;
                    }
                } else {
                    ?>

                    <?php
                }
            }
            ?>

        </ul>
    </div> 
</div>
<div class="clearfix"></div>

<div class="huongdan hidden-xs">
    <h3><img class="cacloaithe" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" title="hướng dẫn" alt="Gamecard" />Hướng dẫn</h3>            
    <ul>
        <?php
     
        $items = Article::Itemlimit(5);
                 
        foreach ($items as $article) {
            ?>
            <?php if (Yii::$app->session->get('notation') == 'VND' && ($article->id_khuyenmai == 0 || $article->id_khuyenmai == 1)) { ?>
                <li>
                    <a href="<?php echo SITE_PATH ?>/detail-news/<?php echo $article->slug; ?>" title="<?php echo $article->title; ?>">
                        <?= $article->title; ?>
                    </a>
                </li>
            <?php } ?>
            <?php if (Yii::$app->session->get('notation') != 'VND' && ($article->id_khuyenmai == 0 || $article->id_khuyenmai == 2)) { ?>
                <li>
                    <a href="<?php echo SITE_PATH ?>/detail-news/<?php echo $article->slug; ?>" title="<?php echo $article->title; ?>">
                        <?= $article->title; ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>



    </ul>
</div>
<!--
<div class="hidden-xs">
    <img class="app-android-hide" src="<?php echo SITE_PATH; ?>/uploads/tet2018/3.png" title="Quà tặng trung thu" alt="Quà tặng trung thu" />
</div>-->


