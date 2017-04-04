<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Связи';
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
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' =>  function($model){
                        return $model->user_id.': '.$model->getGridUser();
                    }
                ],
                [
                    'attribute' => 'project_id',
                    'format' => 'raw',
                    'value' =>  function($model){
                        return $model->project_id.': '.$model->getGridProject();
                    }
                ],
                'selected',
                'role',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ];
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
            </div>
            <div class="box-footer">

            </div>

        </div>
    </div>
</div>

<?php Pjax::end() ?>
