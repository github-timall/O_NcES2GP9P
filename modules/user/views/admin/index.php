<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Пользователи';
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
                'id',
                'username',
                'email',
                [
                    'header' => 'Roles',
                    'format' => 'raw',
                    'value' => function($model){
                        $roles = $model->getAssignmentRoles();
                        return implode('<br>', $roles);
                    }
                ],
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
