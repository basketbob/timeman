<?php $this->pageTitle = Yii::t('login_view','header') . ' - '; ?>

<!--<script>
    <?/*  if(isset($_POST['LoginForm'])){
            if($model->validate() && $model->login()){
                echo 'window.top.location.href = "' . Yii::app()->createAbsoluteUrl('timer/index') . '";';
            }
        } */?>
</script>-->

<div class="container main">
    <h1><?= Yii::t('login_view','header')?></h1>
    <div class="row">
        <div class="col-md-4">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>

                <div class="row">
                    <?= $form->textField($model, 'email',
                        array('class' => 'form-control', 'placeholder' => Yii::t('login_view', 'email'))
                    ); ?>
                    <?= $form->error($model,'email'); ?>
                </div>

                <div class="row">
                    <?= $form->passwordField($model, 'password',
                        array('class' => 'form-control', 'placeholder' => Yii::t('login_view', 'password'))
                    ); ?>
                    <?= $form->error($model,'password'); ?>
                </div>

                <div class="row rememberMe">
                    <table class="table">
                        <tr>
                            <td>
                                <?= $form->checkBox($model,'rememberMe'); ?>
                                <?= $form->label($model,'rememberMe'); ?>
                                <?= $form->error($model,'rememberMe'); ?>
                            </td>
                            <td align="right"><a href="#"><?=Yii::t('login_view', 'forgot')?></a></td>
                        </tr>
                    </table>
                </div>

                <div class="row buttons">
                    <?= CHtml::submitButton('Login',
                        array('class'=>'btn btn-success form-control', 'value'=> Yii::t('login_view', 'login'))
                    ); ?>
                    <p><a href="#" class="btn btn-danger form-control"><i class="fa fa-google-plus"></i>&nbsp; <?=Yii::t('login_view','google')?></a></p>
                    <p align="center"><?=Yii::t('login_view','registr')?></p>
                </div>

                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>