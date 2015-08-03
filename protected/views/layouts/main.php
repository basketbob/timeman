<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=Yii::t('main_template', 'descr')?>">
    <meta name="keywords" content="<?=Yii::t('main_template', 'keywords')?>">
    <meta name="author" content="Timeman">

	<!-- blueprint CSS framework
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" /> -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

    <link rel="stylesheet" href="//getbootstrap.com/examples/carousel/carousel.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//getbootstrap.com/assets/js/docs.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.3/angular.min.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle) . Yii::t('main_template','site_name'); ?></title>
</head>

<body>
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-56839687-1', 'auto');ga('send', 'pageview');</script>

    <?if(Yii::app()->user->isGuest):?>
    <div id="menu_app" class="navbar-wrapper">
        <div class="container">
    <?endif;?>
            <div class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" id="logo" href="<?=Yii::app()->createAbsoluteUrl('site/index')?>"></a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <?if(Yii::app()->user->isGuest):?>
                            <ul class="nav navbar-nav left-menu">
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/index')?>"><?=Yii::t('main_template', 'home')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/about')?>"><?=Yii::t('main_template', 'about')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/contact')?>" id="contact"><?=Yii::t('main_template', 'contacts')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/pricing')?>"><?=Yii::t('main_template', 'pricing')?></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/login')?>"><?=Yii::t('main_template', 'login')?></a></li>
                            </ul>
                        <?else:?>
                            <ul class="nav navbar-nav left-menu">
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('timer/index')?>"><?=Yii::t('main_template', 'timer')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('reports/index')?>"><?=Yii::t('main_template', 'reports')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('invoices/index')?>"><?=Yii::t('main_template', 'invoices')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('projects/index')?>"><?=Yii::t('main_template', 'projects')?></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                                        <?=Yii::app()->user->getFirst_Name()?><span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="themes">
                                        <li><a href="<?=Yii::app()->createAbsoluteUrl('profile/index')?>"><i class="fa fa-user"></i> <?=Yii::t('main_template', 'profile')?></a></li>
                                        <li><a href="<?=Yii::app()->createAbsoluteUrl('site/logout')?>"><i class="fa fa-sign-out"></i> <?=Yii::t('main_template', 'logout')?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?endif;?>
                    </div>
                </div>
            </div>
    <?if(Yii::app()->user->isGuest):?>
        </div>
    </div>
    <?endif;?>
    <main role="main">
        <?php echo $content; ?>
    </main>
    <div class="container marketing">
        <hr class="featurette-divider">

        <!-- FOOTER -->
        <footer role="contentinfo">
            <p class="pull-right"><a href="#"><?=Yii::t('main_template', 'top')?></a></p>
            <ul class="social pull-right">
                <li><a href="https://plus.google.com/+TimemanOrgApp/"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="https://twitter.com/<?=Yii::t('main_template', 'twitter')?>"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://vk.com/timeman_app"><i class="fa fa-vk"></i></a></li>
                <li><a href="https://www.facebook.com/pages/<?=Yii::t('main_template', 'facebook')?>"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://www.linkedin.com/company/timeman"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="http://www.pinterest.com/timeman_app/"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="http://instagram.com/timeman.app"><i class="fa fa-instagram"></i></a></li>
                <li><a href="skype:timeman.app"><i class="fa fa-skype"></i></a></li>
            </ul>
            <p>&copy; 2014 <?=Yii::t('main_template', 'timeman')?> &middot; <a href="<?=Yii::app()->createAbsoluteUrl('privacy/index')?>"><?=Yii::t('main_template', 'privacy')?></a> &middot; <a href="<?=Yii::app()->createAbsoluteUrl('terms/index')?>"><?=Yii::t('main_template', 'terms')?></a></p>
        </footer>
    </div>

    <script>$(function(){var url=window.location.href;$(".left-menu a").each(function(){if(url==(this.href)){$(this).closest("li").addClass("active");}});});</script>
</body>
</html>
