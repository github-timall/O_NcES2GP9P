<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Приложения';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-index">
    <?php $form = ActiveForm::begin(['action' => ['create']]); ?>
    <div class="row">
        <div class="col-xs-3">
            <?= $form->field($model, 'client_id')->textInput(['placeholder' => 'Название приложения'])->label(false) ?>
        </div>
        <div class="col-xs-3">
            <?= Html::submitButton('Добавить приложение', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

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
        'client_secret',
        [
            'header' => 'Токены',
            'format' => 'raw',
            'value' => function($model){
                return Html::a('Токены', ['/tokens', 'client_id' => $model->client_id], ['class' => 'btn btn-primary']);
            },
        ],
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