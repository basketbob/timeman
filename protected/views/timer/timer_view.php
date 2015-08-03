<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/timer.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/timer.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/timeman.js"></script>

<?php $this->pageTitle= 'Timer - '; ?>

<div class="container">
    <h1><?=Yii::t('timer_view','header')?></h1>
    <div ng-app="timerApp">
        <div ng-controller="timerAppController">
            <form name="timerForm" class="form-inline">
                <input type="text" name="event" class="form-control" placeholder="<?=Yii::t('timer_view','event')?>" ng-model="events.active.name_event" required />
                <select name="project" class="form-control" ng-model="events.active.project" ng-options="project.name_project for project in projects"required>
                    <option style="display:none" value=""><?=Yii::t('timer_view','select_proj')?></option>
                </select>
                <div class="money">
                    <input type="checkbox" value="None" id="money" name="money" ng-model="money" ng-checked="money" hidden />
                    <label for="money"></label>
                </div>
                <timer <?=$start_time?'':'autostart="false"'?> start-time="<?=$start_time?>" interval="1000" max-time-unit="'hour'">
                    <input type="text" id="timer" class="form-control" value="{{hhours}}:{{mminutes}}:{{sseconds}}" ng-disabled="true" />
                </timer>
                <button type="submit" name="start" class="btn btn-success" ng-click="startTimer()" ng-disabled="timerForm.$invalid || timerRunning" ng-show="!timerRunning"><i class="fa fa-clock-o"></i> <?=Yii::t('timer_view','start_timer')?></button>
                <button name="stop" class="btn btn-danger" ng-click="stopTimer()" ng-disabled="!timerRunning" ng-show="timerRunning"><i class="fa fa-close"></i> <?=Yii::t('timer_view','stop_timer')?></button>
            </form>
            <br />
            <div class="row" ng-show="events.inactive">
                <div class="col-md-12 table-scroll">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th><?=Yii::t('timer_view','event')?></th>
                            <th><?=Yii::t('timer_view','project')?></th>
                            <th><?=Yii::t('timer_view','duration')?></th>
                            <th><?=Yii::t('timer_view','start')?></th>
                            <th><?=Yii::t('timer_view','finish')?></th>
                            <th><?=Yii::t('timer_view','delete')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="event in events.inactive | startFrom:currentPage*pageSize | limitTo:pageSize">
                            <td>{{event.name_event}}</td>
                            <td>{{event.name_project}}</td>
                            <td>{{secondsToTime(event.duration)}}</td>
                            <td>{{event.start_time | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                            <td>{{event.end_time | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                            <td><a href="" class="delete" ng-click="deleteEvent(event.id_event, $index)">X</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1" class="btn"><?=Yii::t('timer_view','prev')?></button>
                    {{currentPage+1}} / {{numberOfPages() || 1}}
                    <button ng-disabled="currentPage >= events.inactive.length/pageSize - 1" ng-click="currentPage=currentPage+1" class="btn"><?=Yii::t('timer_view','next')?></button>
                </div>
            </div>
        </div>
    </div>
</div>