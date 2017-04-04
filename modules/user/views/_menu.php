<?php
use yii\bootstrap\Nav;
?>

<?= Nav::widget([
    'options' => [
        'id' => 'nav-bar-user',
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label'   => 'Пользователи',
            'url'     => ['/user/admin/index'],
        ],
        [
            'label'   => 'Роли',
            'url'     => ['/user/role/index'],
            'visible' => Yii::$app->user->identity->getIsAdmin(),
        ],
        [
            'label' => 'Разрешения',
            'url'   => ['/user/permission/index'],
            'visible' => Yii::$app->user->identity->getIsAdmin(),
        ],
        [
            'label' => 'Добавить',
            'visible' => Yii::$app->user->identity->getIsAdmin(),
            'items' => [
                [
                    'label'   => 'Пользователя',
                    'url'     => ['/user/admin/create'],
                ],
                [
                    'label' => 'Роль',
                    'url'   => ['/user/role/create'],
                ],
                [
                    'label' => 'Разрешения',
                    'url'   => ['/user/permission/create'],
                ],
            ],
        ],
    ],
]) ?>