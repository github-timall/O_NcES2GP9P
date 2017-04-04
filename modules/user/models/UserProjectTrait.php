<?php
namespace app\modules\user\models;

use Yii;

use app\modules\user_project\models\User2project;

trait UserProjectTrait
{
    public function getSelectedProject()
    {
        $selected_project = User2project::find()->where(['user_id' => $this->id, 'selected' => 1])->one();
        if ($selected_project)
            return $selected_project->project_id;
    }
}