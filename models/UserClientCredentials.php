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
 */
class UserClientCredentials extends \yii\db\ActiveRecord implements \OAuth2\Storage\ClientCredentialsInterface
{
    public static function tableName()
    {
        return 'oauth_clients';
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token = $module->getServer()->getResourceController()->getToken();
        return !empty($token['user_id'])
            ? static::findIdentity($token['user_id'])
            : null;
    }

    public function checkClientCredentials($client_id, $client_secret = null)
    {
        $client = static::findIdentity($client_id);
        if ($client) {
            if ($client->client_secret == $client_secret)
                return true;
            else
                return false;
        }
        return false;
    }
    
    public function isPublicClient($client_id)
    {
        return false;
    }

    public function getClientDetails($client_id)
    {
        $client = static::findIdentity($client_id);

        $param['redirect_uri'] = $client->redirect_uri;
        $param['client_id'] = $client->client_id;
        $param['grant_types'] = $client->grant_types;
        $param['user_id'] = $client->user_id;
        $param['scope'] = $client->scope;

        return $param;
    }

    public function getClientScope($client_id)
    {
        $client = static::findIdentity($client_id);

        return $client->scope;
    }

    public function checkRestrictedGrantType($client_id, $grant_type)
    {
        $client = static::findIdentity($client_id);
        $client_grant_types = explode(' ', $client->grant_types);
        return in_array($grant_type, $client_grant_types);
    }


    //------------------------------------------------------------------------------------------------------------------

    public static function findIdentity($client_id)
    {
        return static::findOne(['client_id' => $client_id]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }
}