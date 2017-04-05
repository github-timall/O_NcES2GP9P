<?php
namespace app\modules\user\components\widgets\select2;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $css = [
//        'css/select2.min.css',
        'css/chosen.css',
    ];
    public $js = [
//        'js/select2.full.min.js',
        'js/chosen.jquery.js',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__;
        parent::init();
    }
}
