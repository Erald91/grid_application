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
        <div class="col-md-6">
            <form class="form-inline">
                <div class="form-group">
                    <label>Select Election Center:</label>&nbsp;
                    <select 
                        class="form-control select-qender-id" 
                        ng-model="selectedCenter"
                        ng-change="calculateCenterStatistcis()">
                        <option 
                            ng-repeat="center in centers" 
                            value="{{center}}">
                            {{center}}
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
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
</div>