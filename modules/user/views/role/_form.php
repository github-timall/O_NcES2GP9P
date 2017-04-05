<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use app\modules\user\components\widgets\select2\Select2;
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

                    <div class="form-group">
                        <?php echo Html::label('Children'); ?>
                        <?= Select2::widget([
                            'name' => 'Role[children]',
                            'items' => $model->getPermissions(),
                            'selection' => $model->children,
                            'options' => [
                                'data-placeholder' => 'Выберите группы...',
                                'class' => 'form-control',
                            ],
                        ]);?>
                    </div>

                </div>
                <div class="box-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
                </div>

            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>