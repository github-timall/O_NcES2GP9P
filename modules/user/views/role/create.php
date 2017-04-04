<?php
$this->title = 'Создание новой роли';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_menu') ?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>
