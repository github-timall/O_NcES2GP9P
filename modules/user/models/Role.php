<?php
namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Role extends Model
{
    public $name;
    public $description;
    public $children = [];

    protected $manager;

    public function init()
    {
        parent::init();
        $this->manager = Yii::$app->authManager;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'children' => 'Children',
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^[\w][\w-.:]+[\w]$/'],
            [['name', 'description'], 'trim'],
            [['children'], 'safe'],
        ];
    }

    public function create()
    {
        $role = $this->manager->getRole($this->name);
        if (!$role) {
            $role = $this->manager->createRole($this->name);
            $role->description = $this->description;
            if ($this->manager->add($role)) {
                if (is_array($this->children)) {
                    foreach ($this->children as $permission_name) {
                        $permission = $this->manager->getPermission($permission_name);
                        if ($permission)
                            $this->manager->addChild($role, $permission);
                    }
                }
                return true;
            }
        } else {
            $this->addError('name', 'Auth item with such name already exists');
            return false;
        }
    }

    public function update($name)
    {
        if ($name != $this->name) {
            $role = $this->manager->getRole($this->name);
            if ($role) {
                $this->addError('name', 'Auth item with such name already exists');
                return false;
            }
        }

        $role = $this->manager->createRole($this->name);
        $role->description = $this->description;
        if ($this->manager->update($name, $role)) {
            $this->manager->removeChildren($role);
            if (is_array($this->children)) {
                foreach ($this->children as $permission_name) {
                    $permission = $this->manager->getPermission($permission_name);
                    if ($permission)
                        $this->manager->addChild($role, $permission);
                }
            }
            return true;
        }
    }

    public function loadRole($name)
    {
        $role = $this->manager->getRole($name);
        if ($role) {
            $this->name = $role->name;
            $this->description = $role->description;
            $children = $this->manager->getChildren($role->name);
            foreach ($children as $child) {
                $this->children[] = $child->name;
            }
        }
    }

    public function getPermissions()
    {
        $permissions = $this->manager->getPermissions();
        return ArrayHelper::map($permissions, 'name', 'name');
    }
}