<?php
use yii\helpers\Html;

\app\assets\AppAsset::register($this);
$this->title = "Dashboard";
?>

<div ng-controller="DashboardCtrl" >
    <div class="row">
        <div class="col-md-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form class="form-inline">
                <div class="form-group">
                    <label>Select Election Center:</label>&nbsp;
                    <select 
                        class="form-control select-qender-id" 
                        ng-model="selectedCenter"
                        ng-change="calculateCenterStatistcis()"
                        ng-disabled="selectedView == 'Progress Table'">
                        <option 
                            ng-repeat="center in centers" 
                            value="{{center}}">
                            {{center}}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Change view:</label>&nbsp;
                    <select 
                        class="form-control select-qender-id" 
                        ng-model="selectedView"
                        ng-change="checkView()">
                        <option 
                            ng-repeat="view in typeOfViews" 
                            value="{{view}}">
                            {{view}}
                        </option>
                    </select>
                </div>
                <div class="form-group pull-right">
                    <a href="javascript:void(0)" ng-click="exportCSV()">Export Data Table CSV</a>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="row" ng-if="selectedView == 'Billboard'">
        <div class="col-md-12">
            <ul class="list-group">
                <li class="list-group-item" ng-repeat="center in centerData | FilterCenters:selectedCenter">
                    <div class="row">
                        <div class="text-center">
                            <span class="election-center-identifier">Election Center <mark>{{center.qendra_id}}</mark></span>
                        </div>
                        <div class="text-center">
                            <div class="well text-center indicator">
                                <span style="font-size: 25px;">{{center.total}}</span>
                                <br>
                                TOTAL
                            </div>
                            <div class="well text-center indicator">
                                <span style="color: #e43838;font-size: 25px;">{{center.potential}}</span>
                                <br>
                                POTENTIAL VOTES
                            </div>
                            <div class="well text-center indicator">
                                <span style="color: #22a722;font-size: 25px;">{{center.potential_done}}</span>
                                <br>
                                POTENTIAL VOTES (DONE)
                            </div>
                            <div class="well text-center indicator">
                                <span style="color: #fd6a0a;font-size: 25px;">{{center.casual}}</span>
                                <br>
                                CASUAL VOTES
                            </div>
                            <div class="well text-center indicator">
                                <span style="color: #0747e7;font-size: 25px;">{{center.casual_done}}</span>
                                <br>
                                CASUAL VOTES (DONE)
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item text-center" ng-if="!centerData.length">
                    <span class="election-center-identifier">
                        No data found
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row" ng-if="selectedView == 'Data Table'">
        <div class="col-md-12">
            <table class="table table-bordered total-table">
                <thead>
                    <tr>
                        <th class="text-center" ng-repeat="header in tableHeaders" ng-click="orderTableContent(header)">
                            {{header.title}} <span class="glyphicon glyphicon-sort pull-right"></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" ng-repeat="center in centerData | FilterCenters:selectedCenter | orderBy:orderField:order">
                        <td style="font-size: 25px;"><mark><strong>{{center.qendra_id}}</strong></mark></td>
                        <td style="color: #e43838;font-size: 25px;">{{center.potential}}</td>
                        <td style="color: #22a722;font-size: 25px;">{{center.potential_done}}</td>
                        <td style="color: #fd6a0a;font-size: 25px;">{{center.casual}}</td>
                        <td style="color: #0747e7;font-size: 25px;">{{center.casual_done}}</td>
                        <td style="font-size: 25px;">{{center.total}}</td>
                    </tr>
                    <tr ng-if="!centerData.length">
                        <td class="text-center" colspan="6">No data found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" ng-if="selectedView == 'Graphs'">
        <div class="col-md-12">
            <div>
                <ul class="legend-list">
                    <li>
                       <strong>Legend:</strong> 
                    </li>
                    <li>
                       <span class="glyphicon glyphicon-th-large" aria-hidden="true" style="color: #e43838"></span>
                       &nbsp;Potential Vote <strong>(State = 1)</strong>
                    </li>
                    <li>
                        <span class="glyphicon glyphicon-th-large" aria-hidden="true" style="color: #22a722"></span>
                        &nbsp;Potential Vote (DONE) <strong>(State = 2)</strong>
                    </li>
                    <li>
                        <span class="glyphicon glyphicon-th-large" aria-hidden="true" style="color: #fd6a0a"></span>
                        &nbsp;Casual Vote <strong>(State = 0)</strong>
                    </li>
                    <li>
                        <span class="glyphicon glyphicon-th-large" aria-hidden="true" style="color: #0747e7"></span>
                        &nbsp;Casual Vote (DONE) <strong>(State = 3)</strong>
                    </li>
                </ul>
            </div>
            <div ng-repeat="center in centerData | FilterCenters:selectedCenter">
                <div class="text-center">
                    <span class="election-center-identifier">Election Center <mark>{{center.qendra_id}}</mark></span>
                </div>
                <canvas
                    id="pie" 
                    class="chart chart-pie" 
                    chart-data="center.pieData" 
                    chart-labels="labels"
                    chart-colors="colours" 
                    chart-options="options"
                    width="300"
                    height="100">
                </canvas>
            </div>
            <div ng-if="!centerData.length">
                <h3 class="text-center">No data found</h3>
            </div>
            <br>
        </div>
    </div>
    <div class="row" ng-if="selectedView == 'Progress Table'">
        <div class="col-md-12">
            <table class="table table-bordered total-table">
                <thead>
                    <tr>
                        <th class="text-center" ng-repeat="header in progressTableHeaders">
                            {{header.title}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td style="font-size: 25px;"><mark><strong>{{progressTableData.center}}</strong></mark></td>
                        <td style="color: #22a722;font-size: 25px;">{{progressTableData.potential}}</td>
                        <td style="color: #0747e7;font-size: 25px;">{{progressTableData.casual}}</td>
                        <td style="color: #fd6a0a;font-size: 25px;">{{progressTableData.potentialCasual}}</td>
                        <td style="font-size: 25px;">{{progressTableData.total}}</td>
                    </tr>
                    <tr ng-if="!centerData.length">
                        <td class="text-center" colspan="5">No data found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>