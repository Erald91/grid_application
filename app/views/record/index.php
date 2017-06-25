<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
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
    <p>
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
    </p>
<?php //Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'headerRowOptions' => [
            'class' => 'text-center records-table-header-row'
        ],
        'rowOptions' => function($model, $key, $index, $grid) {
            switch($model->pranishem) {
                case 1:
                    return ['class' => 'text-center potential-vote'];
                case 2:
                    return ['class' => 'text-center potential-vote-done'];
                case 0:
                    return ['class' => 'text-center casual-vote'];
                case 3:
                    return ['class' => 'text-center casual-vote-done'];
                default:
                    return ['class' => 'text-center casual-vote'];
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
                    return '<input data-id="' . $model->id . '" data-state="' . $model->pranishem . '" type="checkbox" class="toggle-checkbox hidden" ' . ($model->pranishem == 2 || $model->pranishem == 3 ? 'checked':'') . '>';
                }
            ]

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php //Pjax::end(); ?></div>

<?php Modal::begin([
    'header' => '<h4>Confirm Action</h4>',
    'footer' => '<button type="button" class="btn btn-default" id="closeModal">Cancel</button>
                 <button type="button" class="btn btn-primary" id="proceedModal">Proceed</button>',
    'options' => ['data-backdrop' => 'static', 'data-keyboard' => 'false'],
    'id' => 'confirmModal',
    'size' => Modal::SIZE_SMALL,
    'closeButton' => false
]); ?>

<?php echo 'Are you sure you want to change state of this record?'; ?>

<?php Modal::end(); ?>
<script>
    window.isAdmin = '<?= Yii::$app->user->identity->isAdmin() ?>';
</script>
