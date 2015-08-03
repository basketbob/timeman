<?php $this->pageTitle = Yii::t('invoices_view','header') . ' - '; ?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/invoices.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/invoices.js"></script>

<div class="container" ng-app="invoicesApp"  ng-controller="invoicesAppController">
    <h1><?=Yii::t('invoices_view', 'header')?></h1>
    <div class="row">
        <div class="col-md-3">
            <select ng-model="project_name" ng-options="project.name_project for project in projects" name="project" class="form-control">
                <option style="display:none" value class><?=Yii::t('invoices_view','select_proj')?></option>
            </select>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <input type="text" placeholder="<?=Yii::t('invoices_view','client_email')?>" class="form-control" ng-model="client.email" />
        </div>
        <div class="col-md-3 col-md-offset-1">
            <input type="text" placeholder="<?=Yii::t('invoices_view','client_name')?>" class="form-control" ng-model="client.name" />
        </div>
    </div>
    <div class="row" id="datepicker">

        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-addon"><?=Yii::t('invoices_view','from')?></span>
                <input class="form-control" ng-model="start_date" type="text" id="datepicker_from">
            </div>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <div class="input-group">
                <span class="input-group-addon"><?=Yii::t('invoices_view','to')?></span>
                <input class="form-control" ng-model="end_date" type="text" id="datepicker_to">
            </div>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <div class="input-group">
                <span class="input-group-addon"><?=Yii::t('invoices_view','payday')?></span>
                <input class="form-control" ng-model="payday" type="text" id="datepicker_pay">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <select ng-model="whose" class="form-control" name="whose">
                <option value="personal"><?=Yii::t('invoices_view','personal')?></option>
                <option value="team"><?=Yii::t('invoices_view','team')?></option>
            </select>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <textarea class="form-control" rows="2" ng-model="payment" placeholder="<?=Yii::t('invoices_view','payment')?>"></textarea>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <textarea class="form-control" rows="2" ng-model="other" placeholder="<?=Yii::t('invoices_view','other')?>"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <button ng-click="selectForInvoice()" class="btn btn-success" ng-disabled="!project_name" data-toggle="modal" data-target="#invoiceModal"><?=Yii::t('invoices_view','create')?></button>
        </div>
    </div>

<!--------------------------------------------------------------------------------->
    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=Yii::t('reports_view','close')?></span></button>
                    <h4 class="modal-title">Invoice</h4>
                </div>
                <div class="modal-body invoice">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-9 export-buttons">
                            <!--<button class="btn btn-primary btn-xs" ng-click="exportData()"><i class="fa fa-file-pdf-o"></i> PDF</button>-->
                            <button class="btn btn-primary btn-xs" onclick="window.print()"><i class="fa fa-print"></i> <?=Yii::t('invoices_view','print')?></button>
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" ng-click="clearSendInvoice()"><i class="fa fa-envelope-o"></i> <?=Yii::t('invoices_view','email')?></button>
                        </div>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=Yii::t('reports_view','close')?></span></button>
                                        <h4 class="modal-title" id="ModalLabel"><?=Yii::t('invoices_view','send_invoice')?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" name="export_by_email">
                                            <div class="row">
                                                <div class="col-md-5"><input type="email" name="email" ng-model="client.email" class="form-control" placeholder="<?=Yii::t('reports_view','enter_email')?>" required></div>
                                                <div class="col-md-5 col-md-offset-1"><input type="text" name="name" ng-model="client.name" class="form-control" placeholder="<?=Yii::t('invoices_view','client_name')?>" required></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <textarea class="form-control" rows="2" ng-model="other" placeholder="<?=Yii::t('invoices_view','other')?>"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="checkbox" ng-model="copy"/>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success" ng-disabled="!export_by_email.email.$valid" ng-click="sendInvoice()"><?=Yii::t('reports_view','send')?></button>
                                            <p class="text-danger" ng-show="export_by_email.email.$error.email"><?=Yii::t('reports_view','not_valid')?></p>
                                        </form>
                                        <p class="text-success" ng-show="send_invoice"><?=Yii::t('invoices_view','success')?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h1><a href="http://timeman.org"><img src="/images/invoices_logo.png"></a></h1>
                            <h1><small><?=Yii::t('invoices_view','for')?> "{{project_name.name_project}}"</small></h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <h1><?=Yii::t('invoices_view','invoice')?> #{{id_invoice}}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4><?=Yii::t('invoices_view','from_name')?>: <a href="#"><?=Yii::app()->user->getFirst_Name()?></a></h4>
                                </div>
                                <div class="panel-body">
                                    <p><?=Yii::t('invoices_view','email')?>: <?=Yii::app()->user->name?></p>
                                    <p><?=Yii::t('invoices_view','payment')?>: {{payment}}</p>
                                    <p><?=Yii::t('invoices_view','payday')?>: {{payday}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-2 text-right">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4><?=Yii::t('invoices_view','to_name')?>: {{client.name}}</h4>
                                </div>
                                <div class="panel-body">
                                    <p><?=Yii::t('invoices_view','email')?>: {{client.email}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / end client details section -->
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><h4>#</h4></th>
                            <th><h4><?=Yii::t('invoices_view','table_event')?></h4></th>
                            <!--<th><h4><?/*=Yii::t('invoices_view','table_descr')*/?></h4></th>-->
                            <th><h4><?=Yii::t('invoices_view','table_hours')?></h4></th>
                            <th><h4><?=Yii::t('invoices_view','table_price')?></h4></th>
                            <th><h4><?=Yii::t('invoices_view','sub_total')?></h4></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="event in data.table">
                            <td>{{$index+1}}</td>
                            <td>{{event.name_event}}</td>
                            <!--<td></td>-->
                            <td class="text-right">{{event.bill_duration}}</td>
                            <td class="text-right">{{event.cost}}</td>
                            <td class="text-right">{{event.sub_total}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row text-right">
                        <div class="col-xs-2 col-xs-offset-8">
                            <p>
                                <strong>
                                    <?/*=Yii::t('invoices_view','sub_total')*/?><!--: <br>
                    <?/*=Yii::t('invoices_view','tax')*/?>: <br>-->
                                    <?=Yii::t('invoices_view','total')?>: <br>
                                </strong>
                            </p>
                        </div>
                        <div class="col-xs-2">
                            <strong>
                                <!--${{data.total}} <br>
                                N/A <br>-->
                                ${{data.total}} <br>
                            </strong>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="row">
        <div class="col-md-12 table-scroll">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?=Yii::t('invoices_view','invoice_n')?></th>
                    <th><?=Yii::t('invoices_view','project')?></th>
                    <th><?=Yii::t('invoices_view','payday')?></th>
                    <th><?=Yii::t('invoices_view','client_name')?></th>
                    <th><?=Yii::t('invoices_view','create_date')?></th>
                    <th><?=Yii::t('invoices_view','paid')?></th>
                    <th><?=Yii::t('invoices_view','delete')?></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="invoice in invoices">
                    <td>{{$index+1}}</td>
                    <td>{{invoice.id_invoice}}</td>
                    <td>{{invoice.name_project}}</td>
                    <td>{{invoice.payday*1000 | date : "yyyy/MM/dd"}}</td>
                    <td><span title="{{invoice.client_email}}">{{invoice.client_name}}</span></td>
                    <td>{{invoice.create*1000 | date : "yyyy/MM/dd"}}</td>
                    <td><input type="checkbox" ng-checked="{{invoice.paid}}" ng-disabled="{{invoice.paid}}" ng-click="invoicePaid(invoice.id_invoice)" /></td>
                    <td><a href="#" ng-click="deleteInvoice($index, invoice.id_invoice)">X</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>