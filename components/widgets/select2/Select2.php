<?php
namespace app\components\widgets\select2;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

use app\components\widgets\select2\Select2Asset;

class Select2 extends InputWidget
{
    public $clientOptions;
    public $selection;
    public $items = [];
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (!isset($this->options['multiple']))
            $this->options['multiple'] = 'multiple';
        if (!isset($this->options['data-placeholder']))
            $this->options['data-placeholder'] = ' ';
        echo Html::dropDownList($this->name, $this->selection, $this->items, $this->options);
        $this->registerPlugin();
    }

    protected function registerPlugin()
    {
        $js = [];

        $view = $this->getView();

        Select2Asset::register($view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

//        $js[] = "$('#$id').select2($options);";
        $js[] = "$('#$id').chosen($options);";

        $view->registerJs(implode("\n", $js));
    }
}