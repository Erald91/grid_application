<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Records';
?>
<div class="record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php //Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'headerRowOptions' => [
            'class' => 'text-center records-table-header-row'
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            if($model->pranishem) {
                return ['class' => 'text-center pranishem-ok'];
            } else {
                return ['class' => 'text-center pranishem-nok'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'qendra_id',
            'emertimi',
            'date_lindja',
            'nr_rendor',
            [
                'attribute' => 'pranishem',
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'content' => function($model, $key, $index, $column) {
                    return '<input data-id="' . $model->id . '" type="checkbox" class="toggle-checkbox" ' . ($model->pranishem ? 'checked':'') . '>';
                }
            ]

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php //Pjax::end(); ?></div>
