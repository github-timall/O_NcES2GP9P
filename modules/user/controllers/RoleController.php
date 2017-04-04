<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use app\modules\user\models\Role;

class RoleController extends Controller
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
        $auth = Yii::$app->authManager;

        $roles = $auth->getRoles();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $roles
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Role();

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $model = new Role();
        $model->loadRole($name);

        if ($model->load(\Yii::$app->request->post()) && $model->update($name)) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $auth->remove($role);

        return $this->redirect(['index']);
    }
}
