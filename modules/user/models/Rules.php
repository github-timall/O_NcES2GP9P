<?php
namespace app\modules\user\models;

use Yii;
use yii\base\Object;

class Rules extends Object
{
    public function setRules()
    {
        $auth = Yii::$app->authManager;

        $rule = new \app\modules\user\rules\MailingRule;

        $object_rule = $auth->getRule($rule->name);
        if (!$object_rule)
            $auth->add($rule);

        $mailing = $auth->getPermission('mailing_update');
        $mailing->ruleName = $rule->name;
        $auth->update('mailing_update', $mailing);
    }
}