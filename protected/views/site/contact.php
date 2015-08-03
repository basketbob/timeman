<?php $this->pageTitle = Yii::t('contact_view','header') . ' - '; ?>

<link rel="stylesheet" href="/css/contact.css"/>

<div class="container main">
    <div id="contact">
        <div class="row">
            <div class="col-md-12 head">
                <h1><?= Yii::t('contact_view','header')?></h1>


        <?php if(Yii::app()->user->hasFlash('contact')): ?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('contact'); ?>
            </div>
            </div>
        </div>
        <?php else: ?>
                    <h4><?= Yii::t('contact_view','sub_header')?></h4>
                    <hr/>
                    <p><?= Yii::t('contact_view','descr')?></p>
                </div>
            </div>
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'contact-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1 form_head">
                        <br/><?= Yii::t('contact_view', 'form_head')?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <div class="row">
                            <?php echo $form->textField($model,'name', array('placeholder' => Yii::t('contact_view', 'name'), 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'name'); ?>
                        </div>

                        <div class="row">
                            <?php echo $form->textField($model,'email', array('placeholder' => Yii::t('contact_view', 'email'), 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'email'); ?>
                        </div>

                        <div class="row">
                            <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128,
                                'placeholder' => Yii::t('contact_view', 'subject'), 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'subject'); ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50,'placeholder' => Yii::t('contact_view', 'text'), 'class' => 'form-control')); ?>
                            <?php echo $form->error($model,'body'); ?>
                        </div>
                    </div>
                </div>




                <?php /*if(CCaptcha::checkRequirements()): */?><!--
                    <div class="row">
                        <div>
                            <?php /*$this->widget('CCaptcha'); */?>
                            <?php /*echo $form->textField($model,'verifyCode', array('placeholder' => Yii::t('contact_view', 'verify'), 'class' => 'form-control')); */?>
                        </div>
                        <div class="hint"><?/*=Yii::t('contact_view','verify_desc')*/?></div>
                        <?php /*echo $form->error($model,'verifyCode'); */?>
                    </div>
                --><?php /*endif; */?>

                <div class="row buttons">
                    <div class="col-md-5 col-md-offset-6" align="right"><?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-success', 'value'=> Yii::t('contact_view', 'submit'))); ?></div>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
        <?php endif; ?>
    </div>
</div>