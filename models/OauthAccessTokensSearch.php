<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\models\OauthAccessTokens;
use app\models\UserClientCredentials;

class OauthAccessTokensSearch extends OauthAccessTokens
{
    public $interface_client_id;
    public function rules()
    {
        return [
            [['interface_client_id'], 'string', 'max' => 32],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserClientCredentials::className(), 'targetAttribute' => ['client_id' => 'client_id']],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OauthAccessTokens::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || !$this->interface_client_id) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (!Yii::$app->user->identity->getIsAdmin()) {
            $query->leftJoin(UserClientCredentials::tableName(), UserClientCredentials::tableName().'.client_id = '.OauthAccessTokens::tableName().'.client_id');
            $query->andFilterWhere([UserClientCredentials::tableName().'.user_id' => Yii::$app->user->id]);
        }

        $query->andWhere([OauthAccessTokens::tableName().'.client_id' => $this->interface_client_id]);

        return $dataProvider;
    }
}