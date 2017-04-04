<?php

namespace app\modules\user;

class Module extends \yii\base\Module
{
    public $admins = [];
    public $controllerNamespace = 'app\modules\user\controllers';

    public function init()
    {
        parent::init();
    }
}