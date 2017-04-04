<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oauth_clients".
 *
 * @property string $client_id
 * @property string $client_secret
 * @property string $redirect_uri
 * @property string $grant_types
 * @property string $scope
 * @property integer $user_id
 *
 * @property OauthAccessTokens[] $oauthAccessTokens
 */
class OauthClients extends \yii\db\ActiveRecord
{
    const DEFAULT_GRANT_TYPES = 'client_credentials';
    const DEFAULT_REDIRECT_URI = 'https://i-stom.ru/';

    public static function tableName()
    {
        return 'oauth_clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id'], 'unique'],
            [['user_id'], 'integer'],
            [['client_id', 'client_secret'], 'string', 'max' => 32],
            [['redirect_uri'], 'string', 'max' => 1000],
            [['grant_types'], 'string', 'max' => 100],
            [['scope'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Название приложения',
            'client_secret' => 'Client Secret',
            'redirect_uri' => 'Redirect Uri',
            'grant_types' => 'Grant Types',
            'scope' => 'Scope',
            'user_id' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOauthAccessTokens()
    {
        return $this->hasMany(OauthAccessTokens::className(), ['client_id' => 'client_id']);
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->user_id = Yii::$app->user->id;
        $this->client_secret = md5($this->client_id);
        $this->grant_types = self::DEFAULT_GRANT_TYPES;
        $this->redirect_uri = self::DEFAULT_REDIRECT_URI;
        $this->scope = null;
        return parent::save($runValidation, $attributeNames);
    }

    public function getUserAtt($attr)
    {
        $user = User::findOne($this->user_id);
        if (isset($user->$attr))
            return $user->$attr;
        else
            return '';
    }
}
