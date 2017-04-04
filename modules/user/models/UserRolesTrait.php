<?php
namespace app\modules\user\models;

use Yii;

trait UserRolesTrait
{
    public function getIsAdmin()
    {
        $module = Yii::$app->getModule('user');
        return in_array($this->email, $module->admins);
    }

    public function setAddRoles()
    {
        $roles = [];
        if (!$this->isNewRecord) {
            $auth = Yii::$app->authManager;
            foreach ($auth->getAssignments($this->id) as $name => $assignment) {
                $roles[$assignment->roleName] = $assignment->roleName;
            }
        }
        $this->roles = $roles;
    }

    public function setRoles($roles = [])
    {
        $auth = Yii::$app->authManager;
        foreach ($auth->getAssignments($this->id) as $name => $assignment) {
            $role = $auth->getRole($assignment->roleName);
            $auth->revoke($role, $this->id);
        }
        if (is_array($roles) && $roles !== [] && !$this->isNewRecord) {
            foreach ($roles as $role_name) {
                $role = $auth->getRole($role_name);
                $auth->assign($role, $this->id);
            }
        }
    }

    public function getUnassignedRoles()
    {
        $roles =  [];
        $auth = Yii::$app->authManager;
        foreach ($auth->getRoles() as $name => $role) {
            $roles[$role->name] = $role->name;
        }
        return $roles;
    }

    public function getAssignmentRoles()
    {
        $roles = [];
        $auth = Yii::$app->authManager;
        $assignment = $auth->getAssignments($this->id);
        foreach ($assignment as $role) {
            $roles[$role->roleName] = $role->roleName;
        }
        return $roles;
    }
}