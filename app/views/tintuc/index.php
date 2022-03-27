<?php

use yii\helpers\Html;
use yii\helpers\Url;

$asset = app\assets\AppAsset::register($this);
$this->title = $title;
?>



<h3 class="titlethe">
    <img style="padding-right:5px;" src="<?php echo $asset->baseUrl; ?>/images/icon-hinhmuiten-cacloaithe.png" />
    Tin tức
</h3>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 borderleftrightbottom">
    <?php if (count($items)) : ?>
        <?php
        $i = 1;
        foreach ($items as $article) :
            ?>    

            <?php
            if (Yii::$app->session->get('notation') == 'VND' && ($article->id_khuyenmai == 0 || $article->id_khuyenmai == 1)) {
                ?>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 paddingleftright news-list" <?php if ($i % 2 != 0) { ?> style="margin-right:2%;" <?php } ?>>
                    <p class="new_title">
                        <a href="<?php echo SITE_PATH ?>/detail-news/<?= $article->slug ?>" title="<?php echo $article->title ?>">
                            <?php echo $article->title ?>
                        </a>
                    <p>		
                        <a href="<?php echo SITE_PATH ?>/detail-news/<?= $article->slug ?>" title="<?php echo $article->title ?>">
                            <?php if ($article->image == "") { ?>
                                <img src="<?php echo $asset->baseUrl; ?>/images/logo.png" alt="<?php echo $article->title ?>" title="<?php echo $article->title ?>" />
                            <?php } else { ?>
                                <img src="<?php echo SITE_PATH . $article->image; ?>" alt="<?php echo $article->title ?>" title="<?php echo $article->title ?>" />
                            <?php } ?>
                        </a>
                    <p class="short"><?= $article->short ?></p>
                </div>
                <?php $i++; ?>
            <?php } ?>

            <?php if (Yii::$app->session->get('notation') != 'VND' && ($article->id_khuyenmai == 0 || $article->id_khuyenmai == 2)) { ?>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 paddingleftright news-list" <?php if ($i % 2 != 0) { ?> style="margin-right:2%;" <?php } ?>>
                    <p class="new_title">
                        <a href="<?php echo SITE_PATH ?>/detail-news/<?= $article->slug ?>" title="<?php echo $article->title ?>">
                            <?php echo $article->title ?>
                        </a>
                    <p>		
                        <a href="<?php echo SITE_PATH ?>/detail-news/<?= $article->slug ?>" title="<?php echo $article->title ?>">
                            <?php if ($article->image == "") { ?>
                                <img src="<?php echo $asset->baseUrl; ?>/images/logo.png" alt="<?php echo $article->title ?>" title="<?php echo $article->title ?>" />
                            <?php } else { ?>
                                <img src="<?php echo SITE_PATH . $article->image; ?>" alt="<?php echo $article->title ?>" title="<?php echo $article->title ?>" />
                            <?php } ?>
                        </a>
                    <p class="short"><?= $article->short ?></p>
                </div>
                <?php $i++; ?>
            <?php } ?>


        <?php endforeach; ?>
    <?php else : ?>
        <p>Category is empty</p>
    <?php endif; ?>
    <div class="clearfix"></div>
    <?= $cat->pages() ?>
    <div class="clearfix"></div>
</div>
