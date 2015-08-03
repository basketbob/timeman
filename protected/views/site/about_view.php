<?php $this->pageTitle = Yii::t('about_view','title'); ?>

<link rel="stylesheet" href="/css/about.css"/>

<div class="container main">
    <div class="row">
        <div class="col-md-12 head">
            <h1><?= Yii::t('about_view','header')?></h1>
            <h4><?= Yii::t('about_view','sub_header')?></h4>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" role="tabpanel" id="featuresTab">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#timer" aria-controls="timer" role="tab" data-toggle="tab"><?= Yii::t('about_view','tab_h_timer')?></a></li>
                <li role="presentation"><a href="#report" aria-controls="report" role="tab" data-toggle="tab"><?= Yii::t('about_view','tab_h_report')?></a></li>
                <li role="presentation"><a href="#team" aria-controls="team" role="tab" data-toggle="tab"><?= Yii::t('about_view','tab_h_team')?></a></li>
                <li role="presentation"><a href="#invoice" aria-controls="invoice" role="tab" data-toggle="tab"><?= Yii::t('about_view','tab_h_invoice')?></a></li>
                <li role="presentation"><a href="#protect" aria-controls="protect" role="tab" data-toggle="tab"><?= Yii::t('about_view','tab_h_protect')?></a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="timer">
                    <div class="row featurette">
                        <div class="col-md-7">
                            <h2><?=Yii::t('about_view','timer_h1')?></h2>
                            <p><?= Yii::t('about_view','timer_p1')?></p>
                        </div>
                        <div class="col-md-5">
                            <a href="<?php echo Yii::app()->request->hostInfo; ?>/images/features/<?=Yii::t('about_view','timer_img1')?>.png" title="<?=Yii::t('about_view','timer_h1')?>" target="_blank">
                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/features/<?=Yii::t('about_view','timer_img1')?>.png" alt="<?=Yii::t('about_view','timer_h1')?>" title="<?=Yii::t('about_view','timer_h1')?>"/>
                            </a>
                        </div>
                    </div>
                    <hr class="featurette-divider">
                    <div class="row featurette">
                        <div class="col-md-5">
                            <a href="<?php echo Yii::app()->request->hostInfo; ?>/images/features/<?=Yii::t('about_view','timer_img2')?>.png" title="<?=Yii::t('about_view','timer_h2')?>" target="_blank">
                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/features/<?=Yii::t('about_view','timer_img2')?>.png" alt="<?=Yii::t('about_view','timer_h2')?>" title="<?=Yii::t('about_view','timer_h2')?>"/>
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h2><?=Yii::t('about_view','timer_h2')?></h2>
                            <p><?= Yii::t('about_view','timer_p2')?></p>
                        </div>
                    </div>
                    <hr class="featurette-divider">
                    <div class="row">
                        <div class="col-md-7">
                            <h2><?=Yii::t('about_view','timer_h3')?></h2>
                            <p><?= Yii::t('about_view','timer_p3')?></p>
                        </div>
                        <div class="col-md-5">
                            <a href="<?php echo Yii::app()->request->hostInfo; ?>/images/features/cloud-time-tracking.png" title="<?=Yii::t('about_view','timer_h3')?>" target="_blank">
                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/features/cloud-time-tracking.png" alt="<?=Yii::t('about_view','timer_h3')?>" title="<?=Yii::t('about_view','timer_h3')?>"/>
                            </a>
                        </div>
                    </div>
                    <!--<div class="row featurette">
                        <div class="col-md-6">
                            <h3><?/*=Yii::t('about_view','timer_h4')*/?></h3>
                            <p><?/*= Yii::t('about_view','timer_p4')*/?></p>
                        </div>
                        <div class="col-md-5 col-md-offset-1">
                            <a href="<?php /*echo Yii::app()->request->hostInfo; */?>/images/features/<?/*=Yii::t('about_view','')*/?>.png" title="<?/*=Yii::t('about_view','')*/?>" target="_blank">
                                <img src="<?php /*echo Yii::app()->request->hostInfo; */?>/images/features/<?/*=Yii::t('about_view','')*/?>.png" alt="<?/*=Yii::t('about_view','')*/?>" title="<?/*=Yii::t('about_view','')*/?>"/>
                            </a>
                        </div>
                    </div>-->
                </div>
                <div role="tabpanel" class="tab-pane" id="report">
                    <h3><?=Yii::t('about_view','report_h1')?></h3>
                    <p><?= Yii::t('about_view','report_p1')?></p>
                    <h3><?=Yii::t('about_view','report_h2')?></h3>
                    <p><?= Yii::t('about_view','report_p2')?></p>
                    <h3><?=Yii::t('about_view','report_h3')?></h3>
                    <p><?= Yii::t('about_view','report_p3')?></p>
                    <h3><?=Yii::t('about_view','report_h4')?></h3>
                    <p><?= Yii::t('about_view','report_p4')?></p>
                </div>
                <div role="tabpanel" class="tab-pane" id="team">
                    <h3><?=Yii::t('about_view','team_h1')?></h3>
                    <p><?= Yii::t('about_view','team_p1')?></p>
                    <h3><?=Yii::t('about_view','team_h2')?></h3>
                    <p><?= Yii::t('about_view','team_p2')?></p>
                    <h3><?=Yii::t('about_view','team_h3')?></h3>
                    <p><?= Yii::t('about_view','team_p3')?></p>
                </div>
                <div role="tabpanel" class="tab-pane" id="invoice">
                    <h3><?=Yii::t('about_view','invoice_h1')?></h3>
                    <p><?= Yii::t('about_view','invoice_p1')?></p>
                    <h3><?=Yii::t('about_view','invoice_h2')?></h3>
                    <p><?= Yii::t('about_view','invoice_p2')?></p>
                </div>
                <div role="tabpanel" class="tab-pane" id="protect">
                    <h3><?=Yii::t('about_view','protect_h1')?></h3>
                    <p><?= Yii::t('about_view','protect_p1')?></p>
                    <h3><?=Yii::t('about_view','protect_h2')?></h3>
                    <p><?= Yii::t('about_view','protect_p2')?></p>
                    <h3><?=Yii::t('about_view','protect_h3')?></h3>
                    <p><?= Yii::t('about_view','protect_p3')?></p>
                    <h3><?=Yii::t('about_view','protect_h4')?></h3>
                    <p><?= Yii::t('about_view','protect_p4')?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>$('#featuresTab a').click(function(e){e.preventDefault();$(this).tab('show');});</script>