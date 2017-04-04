<?php
namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class Permission extends Model
{
    public $name;
    public $description;

    private $manager;

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
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^[\w][\w-.:]+[\w]$/'],
            [['name', 'description'], 'trim'],
        ];
    }


    public function create()
    {
        $permission = $this->manager->getPermission($this->name);
        if (!$permission) {
            $permission = $this->manager->createPermission($this->name);
            $permission->description = $this->description;
            return $this->manager->add($permission);
        } else {
            $this->addError('name', 'Auth item with such name already exists');
            return false;
        }
    }

    public function update($name)
    {
        if ($this->name != $name) {
            $permission = $this->manager->getPermission($this->name);
            if ($permission) {
                $this->addError('name', 'Auth item with such name already exists');
                return false;
            }
        }
        $permission = $this->manager->createPermission($this->name);
        $permission->description = $this->description;
        return $this->manager->update($name, $permission);
    }

    public function loadPermission($name)
    {
        $permission = $this->manager->getPermission($name);
        if ($permission) {
            $this->name = $permission->name;
            $this->description = $permission->description;
        }
    }
}