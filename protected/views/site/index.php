<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('site_index', 'title');
?>
<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel" <?if(!Yii::app()->user->isGuest):?>style="top: -20px;"<?endif?>>
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <img src="/images/slide_background.jpg" alt="First slide" />
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1><?=Yii::t('site_index', 'slide1_head')?></h1>
                    <p><?=Yii::t('site_index', 'slide1_desc')?></p>
                    <p><a class="btn btn-lg btn-success" href="<?=Yii::app()->createAbsoluteUrl('site/signup')?>" role="button"><?=Yii::t('site_index', 'button_try')?></a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption">
                    <h1><?=Yii::t('site_index', 'slide2_head')?></h1>
                    <p><?=Yii::t('site_index', 'slide2_desc')?></p>
                    <p><a class="btn btn-lg btn-success" href="<?=Yii::app()->createAbsoluteUrl('site/signup')?>" role="button"><?=Yii::t('site_index', 'button_try')?></a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption">
                    <h1><?=Yii::t('site_index', 'slide3_head')?></h1>
                    <p><?=Yii::t('site_index', 'slide3_desc')?></p>
                    <p><a class="btn btn-lg btn-success" href="<?=Yii::app()->createAbsoluteUrl('site/signup')?>" role="button"><?=Yii::t('site_index', 'button_try')?></a></p>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div>
<!-- /.carousel -->


<!-- Three columns of text below the carousel -->
<div class="container marketing">

    <div class="row">
        <div class="col-lg-4">
            <img class="img-circle" src="/images/timeman_at_work.png" alt="<?=Yii::t('site_index', 'disc1_head')?>">
            <h2><?=Yii::t('site_index', 'disc1_head')?></h2>
            <p><?=Yii::t('site_index', 'disc1_desc')?></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <img class="img-circle" src="/images/timeman_in_business.png" alt="<?=Yii::t('site_index', 'disc2_head')?>">
            <h2><?=Yii::t('site_index', 'disc2_head')?></h2>
            <p><?=Yii::t('site_index', 'disc2_desc')?></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <img class="img-circle" src="/images/timeman_in_life.png" alt="<?=Yii::t('site_index', 'disc3_head')?>">
            <h2><?=Yii::t('site_index', 'disc3_head')?></h2>
            <p><?=Yii::t('site_index', 'disc3_desc')?></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->

    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading"><?=Yii::t('site_index', 'sq1_head_1')?> <span class="text-muted"><?=Yii::t('site_index', 'sq1_head_2')?></span></h2>
            <p class="lead"><?=Yii::t('site_index', 'sq1_desc')?></p>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" src="/images/meet_<?=Yii::app()->language?>.png" alt="Generic placeholder image">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-5">
            <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" src="/images/devices_<?=Yii::app()->language?>.png" alt="Generic placeholder image">
        </div>
        <div class="col-md-7">
            <h2 class="featurette-heading"><?=Yii::t('site_index', 'sq2_head_1')?> <span class="text-muted"><?=Yii::t('site_index', 'sq2_head_2')?></span></h2>
            <p class="lead"><?=Yii::t('site_index', 'sq2_desc')?></p>
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading"><?=Yii::t('site_index', 'sq3_head_1')?> <span class="text-muted"><?=Yii::t('site_index', 'sq3_head_2')?></span></h2>
            <p class="lead"><?=Yii::t('site_index', 'sq3_desc')?></p>
        </div>
        <div class="col-md-5">
            <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
        </div>
    </div>

    <!-- /END THE FEATURETTES -->
</div>