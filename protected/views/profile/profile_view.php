<?php $this->pageTitle = Yii::t('profile_view','header') . ' - '; ?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/profile.js"></script>

<div class="container">
    <h1><?=Yii::t('profile_view', 'header')?></h1>
    <div ng-app="profileApp"  ng-controller="profileAppController">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 col-lg-3" align="center">
                    <div class="form-group">
                        <img alt="User Pic" src="/images/avatar/{{profile.img || 'photo.png'}}" class="img-circle">
                    </div>
                    <div class="form-group">
                        <form action="/profile/update" method="POST" enctype="multipart/form-data">
                            <input type="file" name="avatar" fileread="avatar"/>
                            <input type="submit" class="btn btn-success" ng-show="avatar" value="Change"/>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <input type="email" ng-model="profile.email" placeholder="<?=Yii::t('profile_view', 'email')?>" class="form-control" name="email" disabled/>
                    </div>
                    <div class="form-group">
                        <div>
                        <input type="password" ng-model="profile.currentPassword" ng-change="checkPassword()" ng-model-onblur placeholder="<?=Yii::t('profile_view', 'passw')?>" title="<?=Yii::t('profile_view', 'passw')?>" class="form-control"/>
                        <span ng-show="checkPwd" class="text-success">&#10004;</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" ng-model="profile.newPassword" placeholder="<?=Yii::t('profile_view', 'new_passw')?>" title="<?=Yii::t('profile_view', 'new_passw')?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="password" ng-model="profile.repeatPassword" placeholder="<?=Yii::t('profile_view', 'repeat_passw')?>" title="<?=Yii::t('profile_view', 'repeat_passw')?>" class="form-control"/>
                        <span ng-show="profile.newPassword.length>2 && profile.newPassword===profile.repeatPassword" class="text-success">&#10004;</span>
                    </div>
                    <div class="form-group">
                        <input type="text" ng-model="profile.name_user" placeholder="<?=Yii::t('profile_view', 'name')?>" title="<?=Yii::t('profile_view', 'name')?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="text" ng-model="profile.department" placeholder="<?=Yii::t('profile_view', 'department')?>" title="<?=Yii::t('profile_view', 'department')?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">GMT</span>
                            <select ng-model="profile.timezone" class="form-control" >
                                <option value="12">+12</option>
                                <option value="11">+11</option>
                                <option value="10">+10</option>
                                <option value="9">+09</option>
                                <option value="8">+08</option>
                                <option value="7">+07</option>
                                <option value="6">+06</option>
                                <option value="5">+05</option>
                                <option value="4">+04</option>
                                <option value="3">+03</option>
                                <option value="2">+02</option>
                                <option value="1">+01</option>
                                <option value="0">00</option>
                                <option value="-1">-01</option>
                                <option value="-2">-02</option>
                                <option value="-3">-03</option>
                                <option value="-4">-04</option>
                                <option value="-5">-05</option>
                                <option value="-6">-06</option>
                                <option value="-7">-07</option>
                                <option value="-8">-08</option>
                                <option value="-9">-09</option>
                                <option value="-10">-10</option>
                                <option value="-11">-11</option>
                                <option value="-12">-12</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group text-success" ng-show="resultUpdate">
                        <?=Yii::t('profile_view', 'result_update')?>
                    </div>
                    <div class="form-group" align="right">
                        <button ng-click="updateProfile()" class="btn btn-success"><?=Yii::t('profile_view', 'save')?></button>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3"></div>
            </div>
        </div>
    </div>
</div>