<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\models\Rules;


class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->getIsAdmin();
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $user = new User();

        if ($user->load(\Yii::$app->request->post())) {
            $user->setPassword($user->password);
            $user->generateAuthKey();
            $user->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $user,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findOne($id);

        $model->setAddRoles();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->password)
                $model->setPassword($model->password);

            $model->save();
            $user = Yii::$app->request->post('User');
            if (isset($user['roles']))
                $model->setRoles($user['roles']);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = User::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }
    
    public function actionRules()
    {
        $rules = new Rules();
        $rules->setRules();
        return $this->redirect(['index']);
    }
    
    public function actionProject()
    {
        $project = new UserProject();
        $project->name = 'Default';
        $project->save();
        return $this->redirect(['index']);
    }
    
    public function actionTest()
    {
        
    }
}
