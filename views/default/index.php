<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;
use andahrm\positionSalary\models\PersonPositionSalary;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\positionSalary\models\PersonPositionSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/position-salary', 'Person Position Salaries');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$columns = [
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
    'status' => [
        'attribute' => 'status',
        'filter' => PersonPositionSalary::getItemStatus(),
        'value' => 'statusLabel',
    //'group'=>true,
    ],
    'edoc_id' => [
        'attribute' => 'edoc_id',
        //'filter' => Edoc::getList(),
        'format' => 'html',
        'value' => 'edoc.codeTitle',
    //'group'=>true,
    ],
    'user_id' => [
        'attribute' => 'user_id',
        //'filter' => Person::getList(),
        'format' => 'html',
        'value' => function($model) {
            return $model->user->getInfoMedia(['view', 'edoc_id' => $model->edoc_id]);
        },
        'contentOptions' => ['width' => '200']
    ],
    'fullname' => [
        'attribute' => 'user_id',
        //'filter' => Person::getList(),
        'value' => 'user.fullname'
    ],
    'position_id' => [
        'attribute' => 'position_id',
        //'filter' => Position::getList(),
        'format' => 'html',
        'value' => 'positionTitleCode'
    ],
    'adjust_date' => 'adjust_date:date',
    'title' => [
        'attribute' => 'title',
        'format' => 'html',
        'value' => 'titleStep'
    ],
    'salary' => 'salary:decimal',
    'step' => 'step',
    'level' => 'level',
];

$gridColumns = [
    ['class' => '\kartik\grid\SerialColumn'],
    $columns['adjust_date'],
    $columns['user_id'],
    $columns['title'],
    $columns['position_id'],
    $columns['level'],
    //$columns['status'],
    $columns['salary'],
    $columns['edoc_id'],
    ['class' => '\kartik\grid\ActionColumn',
        'template' => '{view} {delete}',
    ]
];

$fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'filename' => $this->title,
            'showConfirmAlert' => false,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
            'encoding' => 'utf-8',
            'pjaxContainerId' => 'kv-pjax-container',
            'dropdownOptions' => [
                'label' => 'Full',
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_PDF => [
                        'encoding' => 'utf8',
                        'mime' => 'application/pdf',
                        'extension' => 'pdf',
                        'writer' => 'PDF'
                    ],
                ],
            ],
        ]);
?>
<div class="person-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax' => true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
        'panel' => [
            //'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
//             'type'=>'primary',
            'before' => '<div class="btn-group">' .
            Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('andahrm', 'Create'), ['create'], [
                'class' => 'btn btn-success btn-flat',
                'data-pjax' => 0
            ]) . ' ' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('andahrm', 'Reload'), '#!', [
                'class' => 'btn btn-info btn-flat btn-reload',
                'title' => 'Reload',
                'id' => 'btn-reload-grid'
            ]) . ' ' .
            Html::a('<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('andahrm', 'Trash'), ['trash/index'], [
                'class' => 'btn btn-warning btn-flat',
                'data-pjax' => 0
            ]) . ' ' .
            '</div>',
            'heading' => false,
        //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
        'columns' => $gridColumns,
    ]);
    ?>
</div>
<?php
$js[] = "
$(document).on('click', '#btn-reload-grid', function(e){
    e.preventDefault();
    $.pjax.reload({container: '#data-grid-pjax'});
});
";

$this->registerJs(implode("\n", $js));
