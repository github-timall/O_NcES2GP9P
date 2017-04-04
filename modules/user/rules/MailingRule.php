<?php
namespace app\modules\user\rules;

use yii;
use yii\rbac\Rule;

use app\modules\user_project\models\User2project;

/**
 * Проверяем authorID на соответствие с пользователем, переданным через параметры
 */
class MailingRule extends Rule
{
    public $name = 'isUpdateMailing';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $user_selected_project = User2project::find()->where(['user_id' => $user, 'selected' => 1])->one();
        if ($user_selected_project)
            return isset($params['project_id']) ? $params['project_id'] == $user_selected_project->project_id : false;
        else
            return false;
    }
}