<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>

                <div class="box-body">
                    <?= $form->field($model, 'name') ?>

                    <?= $form->field($model, 'description') ?>
                </div>
                <div class="box-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
                </div>

            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>