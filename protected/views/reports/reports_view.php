<?php $this->pageTitle = 'Reports - '; ?>

<link rel="stylesheet" href="/css/reports.css"/>
<script src="/js/reports.js"></script>
<script src="/js/fileSaver.js"></script>

<div class="container" ng-app="reportsApp"  ng-controller="reportsController">
    <div class="row reports-top">
        <div class="col-md-12 form-inline">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-default btn-xs" ng-click="prevPeriod()">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-xs" ng-click="nextPeriod()">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                    <h3>{{period}}: <span>{{data.period.from}}</span><span ng-show="period!=='Day'"> - {{data.period.to}}</span></h3>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-2 end">
                    <select name="period" class="form-control" ng-model="period">
                        <option value="Day"><?=Yii::t('reports_view','day')?></option>
                        <option value="Week"><?=Yii::t('reports_view','week')?></option>
                        <option value="Month"><?=Yii::t('reports_view','month')?></option>
                        <option value="Year"><?=Yii::t('reports_view','year')?></option>
                        <option value="Custom"><?=Yii::t('reports_view','custom')?></option>
                    </select>
                </div>
            </div>
            <div id="datepicker" ng-show="period == 'Custom'">
                <?=Yii::t('reports_view','view_report')?>
                <input class="form-control" ng-model="start_date" type="text" id="datepicker_from">
                <?=Yii::t('reports_view','to')?>
                <input class="form-control" ng-model="end_date" type="text" id="datepicker_to">
                &nbsp;
                <button class="btn btn-success btn-sm" href="#" ng-click="selectEvents();"><?=Yii::t('reports_view','update')?></button>
            </div>
            <hr/>
            <div class="row reports-summary">
                <div class="col-md-4">
                    <h2><?=Yii::t('reports_view','h_tracked')?></h2>
                    <h3>{{total.all_hours}}</h3>
                </div>
                <div class="col-md-4 billable-percent">
                    <div id="cont" data-pct="{{total.percent || 0}}">
                        <svg id="svg" width="92" height="92" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <circle r="32" cx="46" cy="46" fill="transparent" stroke-dasharray="201.1" stroke-dashoffset="0"></circle>
                            <circle id="bar" r="32" cx="46" cy="46" fill="transparent" stroke-dasharray="201.1" stroke-dashoffset="0"></circle>
                        </svg>
                        <span>{{total.percent || 0}}%</span>
                    </div>
                    <div class="billable-percent-info">
                        <h2><?=Yii::t('reports_view','work_h')?></h2>
                        <ul>
                            <li>
                                <span class="billable-percent-key"><?=Yii::t('reports_view','bill')?></span>
                                {{total.bill_hours}}
                                <span><?=Yii::t('reports_view','bill')?></span>
                            </li>
                            <li>
                                <span class="billable-percent-key key-unbillable"><?=Yii::t('reports_view','unbill')?></span>
                                {{total.unbill_hours}}
                                <span><?=Yii::t('reports_view','unbill')?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <h2><?=Yii::t('reports_view','bill_amount')?></h2>
                    <h3>${{total.cost}}</h3>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <input type="text" placeholder="<?=Yii::t('reports_view','event')?>" class="form-control" name="id" ng-model="filter.name_event" />
                </div>
                <div class="col-md-3">
                    <select name="project" class="form-control" ng-model="filter.name_project" ng-options="project for (key, project) in data.projects">
                        <option value><?=Yii::t('reports_view','all_proj')?></option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="user_name" class="form-control" ng-model="filter.user_name">
                        <option value ng-selected="true"><?=Yii::t('reports_view','team')?></option>
                        <option value="<?=Yii::app()->user->getFirst_Name()?>"><?=Yii::t('reports_view','private')?></option>
                    </select>
                </div>
                <div class="col-md-3 end" ng-show="data.events">
                    <?=Yii::t('reports_view','export')?>
                    <button class="btn btn-primary btn-xs" ng-click="exportData()"><i class="fa fa-file-excel-o"></i> XLS</button>
                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" ng-click="clearSendReport()"><i class="fa fa-envelope-o"></i> <?=Yii::t('reports_view','email')?></button>
                </div>
            </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=Yii::t('reports_view','close')?></span></button>
                            <h4 class="modal-title" id="ModalLabel"><?=Yii::t('reports_view','send_report')?></h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" name="export_by_email">
                                <input type="email" name="email" ng-model="email" class="form-control" placeholder="<?=Yii::t('reports_view','enter_email')?>" required>
                                <button type="button" class="btn btn-success" ng-disabled="!export_by_email.email.$valid" ng-click="sendReport()"><?=Yii::t('reports_view','send')?></button>
                                <p class="text-danger" ng-show="export_by_email.email.$error.email"><?=Yii::t('reports_view','not_valid')?></p>
                            </form>
                            <p class="text-success" ng-show="send_report"><?=Yii::t('reports_view','success')?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row reports-table">
        <div class="col-md-12 table-scroll" id="exportable">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th><a href="" ng-click="predicate = 'index'; reverse=!reverse">#</a></th>
                    <th><?=Yii::t('reports_view','event')?></th>
                    <th><?=Yii::t('reports_view','proj')?></th>
                    <th><?=Yii::t('reports_view','user_name')?></th>
                    <th><?=Yii::t('reports_view','hours')?></th>
                    <th><?=Yii::t('reports_view','bill_h')?></th>
                    <th><?=Yii::t('reports_view','bill_amount')?></th>
                    <th><a href="" ng-click="predicate = 'start_time'; reverse=!reverse"><?=Yii::t('reports_view','start')?></a></th>
                    <th><a href="" ng-click="predicate = 'end_time'; reverse=!reverse"><?=Yii::t('reports_view','end')?></a></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="(index, event) in data.events | filter:{name_event: filter.name_event,
                    name_user: filter.user_name, name_project: filter.name_project||undefined} | orderBy:predicate:reverse"
                >
                    <td class="index">{{index+1}}</td>
                    <td>{{event.name_event}}</td>
                    <td class="name_project">{{event.name_project}}</td>
                    <td class="user_name">{{event.name_user}}</td>
                    <td class="duration">{{event.duration}}</td>
                    <td class="duration">{{event.bill_duration}}</td>
                    <td class="cost">{{event.cost || 0}}</td>
                    <td class="time">{{event.start_time}}</td>
                    <td class="time">{{event.end_time}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>