<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Разрешения';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_menu') ?>

<?php Pjax::begin() ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>

            <div class="box-body">
                <?php
                $gridColumns = [
                    'name',
                    'description',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'name' => $model->name]);
                            },
                                'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'name' => $model->name], ['data-method' => 'post']);
                            },
                        ],
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                ]); ?>
            </div>
            <div class="box-footer">

            </div>

        </div>
    </div>
</div>
<?php Pjax::end() ?>