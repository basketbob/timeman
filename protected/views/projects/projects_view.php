<?php $this->pageTitle = Yii::t('projects_view','header') . ' - '; ?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/projects.js"></script>

<div class="container">
    <h1><?=Yii::t('projects_view', 'header')?></h1>

    <div ng-app="projectApp" ng-controller="projectAppController">
        <form name="projectForm" class="form-inline">
            <input type="text" class="form-control" ng-model="nameProject" placeholder="<?=Yii::t('projects_view','placeholder_proj')?>" required />
            <input type="number" class="form-control" ng-model="costProject" placeholder="<?=Yii::t('projects_view','placeholder_cost')?>" />
            <button class="btn btn-success btn-sm" ng-click="newProject()" ng-disabled="projectForm.$invalid"><?=Yii::t('projects_view','create')?></button>
        </form>
        <br />
        <div class="row table-scroll">
            <table ng-show="projects" class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?=Yii::t('projects_view', 'table_proj')?></th>
                    <th><?=Yii::t('projects_view', 'table_role')?></th>
                    <th><?=Yii::t('projects_view', 'table_team')?></th>
                    <th><?=Yii::t('projects_view', 'table_stat')?></th>
                    <th><?=Yii::t('projects_view', 'table_cost')?></th>
                    <th><?=Yii::t('projects_view', 'table_summ')?></th>
                    <th><?=Yii::t('projects_view', 'table_del')?></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="project in projects">
                    <td>{{$index+1}}</td>
                    <td>{{project.name_project}}</td>
                    <td>{{(project.admin === '1') ? '<?=Yii::t('projects_view','admin')?>' : '<?=Yii::t('projects_view','user')?>'}}</td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#teamModal{{project.id_project}}" ng-show="$index>0">{{sizeOf(project.team) || 0}}</a>
                        <div class="modal fade" id="teamModal{{project.id_project}}" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel{{project.id_project}}" aria-hidden="true" ng-show="project.id_project != 1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="teamModalLabel{{project.id_project}}"><?=Yii::t('projects_view','team_head')?>{{project.name_project}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?=Yii::t('projects_view','team_name')?></th>
                                                <th><?=Yii::t('projects_view','team_email')?></th>
                                                <th ng-show="project.admin==='1'"><?=Yii::t('projects_view','table_del')?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="(id_user, user) in project.team">
                                                <td>{{$index+1}}</td>
                                                <td>{{user.name_user}}</td>
                                                <td>{{user.email}}</td>
                                                <td ng-show="project.admin==='1'"><a href="" class="delete" ng-click="deleteMember(project.id_project, id_user, $index)">X</a></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <form action="#" name="addNewMember" ng-show="project.admin">
                                            <input type="email" name="email" ng-model="email" class="form-control" placeholder="<?=Yii::t('projects_view','enter_email')?>" required>
                                            <br/>
                                            <button type="button" class="btn btn-success" ng-disabled="!addNewMember.email.$valid" ng-click="newMember(email, project.id_project, project.name_project)">+ <?=Yii::t('projects_view','new_user')?></button>
                                            <p class="text-danger" ng-show="addNewMember.email.$error.email"><?=Yii::t('projects_view','not_valid')?></p>
                                        </form>
                                        <p class="text-success" ng-show="addedMember"><?=Yii::t('projects_view','success')?></p>
                                        <p class="text-danger" ng-show="addedMember === 0"><?=Yii::t('projects_view','already_add')?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{Math.floor(project.duration/3600) || 0}} <?=Yii::t('projects_view','hours')?></td>
                    <td><span ng-show="$index>0">{{project.cost}}</span></td>
                    <td><span ng-show="$index>0">{{secondsToHours(project.duration) * project.cost}}</span></td>
                    <td><a href="" ng-show="project.id_project != 1" class="delete" ng-click="deleteProject(project.id_project, $index)">X</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>