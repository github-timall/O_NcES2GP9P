<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Токены';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-index">

    <?php
    $gridColumns = [
        [
            'attribute' => 'user_id',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getUserAtt('email');
            }
        ],
        'client_id',
        'access_token',
        'expires',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]); ?>

</div>