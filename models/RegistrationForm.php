<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            [['username'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Пароль еще раз',
        ];
    }

    public function createUser()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->username;
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->setPassword($this->password);
        $user->status = User::STATUS_BANNED;
        return $user->save();
    }
}
