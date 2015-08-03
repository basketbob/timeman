<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Value your time. Manage your life. Coming soon.">
    <meta name="author" content="Timeman">

	<!-- blueprint CSS framework
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" /> -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" href="//getbootstrap.com/examples/carousel/carousel.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//getbootstrap.com/assets/js/docs.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.3/angular.min.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
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
                        <a class="navbar-brand" id="logo" href="#"></a>
                    </div>
                    <div class="navbar-collapse collapse" ng-conroller="menuController">
                        <?if(Yii::app()->user->isGuest):?>
                            <ul class="nav navbar-nav">
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/index')?>"><?=Yii::t('main_template', 'home')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/about')?>"><?=Yii::t('main_template', 'about')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/contact')?>"><?=Yii::t('main_template', 'contacts')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('site/pricing')?>"><?=Yii::t('main_template', 'pricing')?></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#loginModal" id="theme111">
                                        <?=Yii::t('main_template', 'login')?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="themes" id="guest_login">
                                        <li>
                                            <form action="<?=Yii::app()->createAbsoluteUrl('site/login')?>" method="post" name="loginForm" class="form-signin">
                                                <input type="text" class="form-control" placeholder="<?=Yii::t('main_template', 'email')?>" name="LoginForm[email]" />
                                                <input type="password" class="form-control" placeholder="<?=Yii::t('main_template', 'password')?>" name="LoginForm[password]" />
                                                <button type="submit" class="btn btn-primary btn-sm"><?=Yii::t('main_template', 'login')?></button>
                                                <a href="<?=Yii::app()->createAbsoluteUrl('site/registration')?>"><?=Yii::t('main_template', 'regist')?></a>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        <?else:?>
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="<?=Yii::app()->createAbsoluteUrl('timer/index')?>"><?=Yii::t('main_template', 'timer')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('reports/index')?>"><?=Yii::t('main_template', 'reports')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('invoices/index')?>"><?=Yii::t('main_template', 'invoices')?></a></li>
                                <li><a href="<?=Yii::app()->createAbsoluteUrl('projects/index')?>"><?=Yii::t('main_template', 'projects')?></a></li>
                                <li class="dropdown">
                                    <a href="/timer/settings" class="dropdown-toggle" data-toggle="dropdown">
                                        <?=Yii::t('main_template', 'settings')?> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="dropdown-header">Time</li>
                                        <li><a href="<?=Yii::app()->createAbsoluteUrl('timer/settings')?>">Daily</a></li>
                                        <li><a href="#">Weekly</a></li>
                                        <li><a href="#">Monthly</a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Type</li>
                                        <li><a href="#">By events</a></li>
                                        <li><a href="#">By projects</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                                        <?=Yii::app()->user->name?><span class="caret"></span>
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

    <!--<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <iframe src="<?/*=Yii::app()->createAbsoluteUrl('site/login')*/?>" frameborder="0" scrolling="no" height="  auto"></iframe>
                </div>
            </div>
        </div>
    </div>-->

        <?php echo $content; ?>
    <div class="container marketing">
        <hr class="featurette-divider">

        <!-- FOOTER -->
        <footer>
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
</body>
</html>
