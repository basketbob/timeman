<?php $this->pageTitle = Yii::t('pricing_view','header') . ' - '; ?>

<link rel="stylesheet" href="<?=Yii::app()->request->baseUrl?>/css/pricing.css"/>

<div class="container main">
    <h1><?=Yii::t('pricing_view', 'header')?></h1>
    <p><?=Yii::t('pricing_view', 'descr')?></p>
    <br/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered table-striped pricing">
                <tr>
                    <th class="empty"></th>
                    <th><?=Yii::t('pricing_view', 'table1_h1')?></th>
                    <th><?=Yii::t('pricing_view', 'table1_h2')?></th>
                </tr>
                <tr>
                    <th class="empty"></th>
                    <th class="price"><?=Yii::t('pricing_view', 'table1_h1_1')?></th>
                    <th class="price"><?=Yii::t('pricing_view', 'table1_h2_1')?></th>
                </tr>
                <tbody>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row1_1')?></td>
                        <td>1</td>
                        <td><?=Yii::t('pricing_view', 'unlim')?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row2_1')?></td>
                        <td><?=Yii::t('pricing_view', 'table1_row2_2')?></td>
                        <td><?=Yii::t('pricing_view', 'unlim')?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row3_1')?></td>
                        <td><?=Yii::t('pricing_view', 'unlim')?></td>
                        <td><?=Yii::t('pricing_view', 'unlim')?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row4_1')?></td>
                        <td><?=Yii::t('pricing_view', 'table1_row4_2')?></td>
                        <td><?=Yii::t('pricing_view', 'table1_row4_3')?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row5_1')?></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row6_1')?></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row7_1')?></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row8_1')?></td>
                        <td></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'table1_row9_1')?></td>
                        <td></td>
                        <td><i class="fa fa-check-circle fa-lg"></i></td>
                    </tr>
                    <tr>
                        <td class="empty"></td>
                        <td><a href="<?=Yii::app()->createAbsoluteUrl('site/signup')?>" class="btn btn-success"><?=Yii::t('pricing_view', 'singup')?></a></td>
                        <td><a href="<?=Yii::app()->createAbsoluteUrl('site/signup')?>" class="btn btn-success"><?=Yii::t('pricing_view', 'singup')?></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p><?=Yii::t('pricing_view', 'p1')?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered table-striped discount">
                <tr>
                    <th><?=Yii::t('pricing_view', 'table2_h1')?></th>
                    <th>1</th>
                    <th>50</th>
                    <th>200</th>
                    <th>500</th>
                </tr>
                <tr>
                    <td><?=Yii::t('pricing_view', 'table2_row1')?></td>
                    <td></td>
                    <td class="green">-5%</td>
                    <td class="green">-10%</td>
                    <td class="green">-20%</td>
                </tr>
                <tr>
                    <td></td>
                    <td>$3</td>
                    <td>$142.50</td>
                    <td>$540</td>
                    <td>$1,200</td>
                </tr>
                <tr>
                    <td><?=Yii::t('pricing_view', 'table2_row3')?></td>
                    <td></td>
                    <td class="green">-25%</td>
                    <td class="green">-30%</td>
                    <td class="green">-40%</td>
                </tr>
                <tr>
                    <td></td>
                    <td>$36</td>
                    <td>$1,350</td>
                    <td>$5,040</td>
                    <td>$10,800</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" ng-app="pricingApp" ng-controller="pricingAppCtrl">
        <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-success" ng-click="show_calc=!show_calc"><i class="fa fa-calculator"></i> <?=Yii::t('pricing_view', 'calc_price')?></button>
            <div class="calculator" ng-show="show_calc">
                <table>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'currency')?></td>
                        <td>
                            <select ng-model="valuta">
                                <option value="2">USD</option>
                                <option value="1"><?=Yii::t('pricing_view', 'rur')?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?=Yii::t('pricing_view', 'num_users')?></strong></td>
                        <td><input ng-model="total_users" title="<?=Yii::t('pricing_view', 'disc_num')?>" type="text" maxlength="4"></td>
                    </tr>
                    <tr>
                        <td><strong><?=Yii::t('pricing_view', 'period')?></strong></td>
                        <td><input ng-model="total_time" title="<?=Yii::t('pricing_view', 'disc_period')?>" type="text" maxlength="2"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'total')?></td>
                        <td>{{total_sum}}</td>
                    </tr>
                    <tr class="green">
                        <td><?=Yii::t('pricing_view', 'discount')?></td>
                        <td>{{discount}}</td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('pricing_view', 'for_pay')?></td>
                        <td>{{final_sum}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p class="ps"><?=Yii::t('pricing_view', 'p2')?></p>
        </div>
    </div>
</div>
<script src="<?=Yii::app()->request->baseUrl?>/js/pricing.js"></script>