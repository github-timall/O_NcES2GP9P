<?php
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?= $form->field($model, 'user_id')->dropDownList($model->getUsers()); ?>

                    <?= $form->field($model, 'project_id')->dropDownList($model->getProjects()); ?>

                    <?= $form->field($model, 'selected')->checkbox(); ?>

                    <?= $form->field($model, 'role')->dropDownList($model->getRoles()); ?>
                </div>
                <div class="box-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
                </div>

            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>