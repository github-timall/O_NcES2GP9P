<?php
$this->title = 'Создание нового разрешения';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_menu') ?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>
