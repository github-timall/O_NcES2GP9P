<?php
namespace app\modules\user\models;

use app\models\User as BaseUser;

use app\modules\user\models\UserRolesTrait;
use app\modules\user\models\UserCenterTrait;

class User extends BaseUser
{
    use UserRolesTrait;
    use UserProjectTrait;

    public $roles = [];
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['roles'], 'safe'],
        ];
    }
}
