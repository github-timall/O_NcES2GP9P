<?php
$this->title = 'Создание новой связи';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_menu') ?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>
