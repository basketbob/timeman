<?php $this->pageTitle = Yii::t('signup_view','header') . ' - '; ?>

<div class="container main">
    <h1><?= Yii::t('signup_view','header')?></h1>
    <div class="row">
        <div class="col-md-5">
            <? if(Yii::app()->user->hasFlash('registration')): ?>
                <div class="flash-success"><?= Yii::app()->user->getFlash('registration'); ?></div>
            <? else: ?>

                <div class="form">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'user-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation'=>false,
                    )); ?>

                    <div class="row">
                        <?php echo $form->textField($model,'email',array(
                            'size' => 60, 'maxlength' => 128,'class' => 'form-control',
                            'placeholder' => Yii::t('signup_view', 'email')
                        )); ?>
                        <?= $form->error($model,'email'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->passwordField($model,'password',array(
                            'size' => 60,'maxlength' => 128, 'class' => 'form-control',
                            'placeholder' => Yii::t('signup_view', 'password')
                        )); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>

                    <?php if(CCaptcha::checkRequirements()): ?>
                        <div class="row">
                            <div>
                                <?php $this->widget('CCaptcha'); ?>
                                <?php echo $form->textField($model,'verifyCode',
                                    array('placeholder' => Yii::t('signup_view', 'verify'), 'class' => 'form-control',)
                                ); ?>
                            </div>
                            <div class="hint"><?=Yii::t('signup_view','verify_desc')?></div>
                            <?= $form->error($model,'verifyCode'); ?>
                        </div>
                    <? endif; ?>
                    <br/>
                    <div class="row">
                        <p><?= $form->checkBox($model,'spam'); ?> <?=Yii::t('signup_view','agree_news')?></p>
                        <p><?=Yii::t('signup_view','agreement')?></p>
                    </div>

                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Sign up',
                            array('class'=>'btn btn-success form-control', 'value'=> Yii::t('signup_view', 'signup'))
                        ); ?>
                        <p><a href="#" class="btn btn-danger form-control">
                                <i class="fa fa-google-plus"></i>&nbsp;<?=Yii::t('signup_view','google')?>
                            </a></p>
                    </div>

                    <div class="row"><p align="center">
                        <?=Yii::t('signup_view','login1')?>
                        <a href="<?=Yii::app()->createAbsoluteUrl('site/login')?>"><?=Yii::t('signup_view','login_link')?></a>
                    </p></div>

                    <?php $this->endWidget(); ?>
                </div><!-- form -->
            <?php endif;?>
        </div>
    </div>
</div>
