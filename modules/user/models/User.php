<?php
namespace app\modules\user\models;

use Yii;

class User extends \app\models\User
{

    public $roles = [];
    public $password;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'afterInsertOptions']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'afterUpdateOptions']);
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'afterValidateOptions']);
        $this->on(self::EVENT_AFTER_FIND, [$this, 'afterFindOptions']);
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BANNED, self::STATUS_DELETED]],
            [['roles'], 'safe'],
        ];
    }

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

    public function checkRoles($post)
    {
        if (!isset($post['User']['roles'])) {
            $this->roles = [];
        }
        return true;
    }

    public function afterFindOptions()
    {
        $this->setAddRoles();
    }

    public function afterValidateOptions()
    {
        if ($this->password) {
            $this->setPassword($this->password);
        }

        $this->generateAuthKey();
    }

    public function afterInsertOptions()
    {
        $this->setRoles($this->roles);
    }

    public function afterUpdateOptions()
    {
        $this->setRoles($this->roles);
    }
}
