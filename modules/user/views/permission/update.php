<?php
$this->title = 'Редактирование: '.$model->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_menu') ?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>
