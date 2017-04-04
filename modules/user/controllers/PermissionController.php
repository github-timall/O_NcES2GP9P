<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use app\modules\user\models\Permission;

class PermissionController extends Controller
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

        $permissions = $auth->getPermissions();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $permissions
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Permission();


        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $model = new Permission();
        $model->loadPermission($name);

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
        $permission = $auth->getPermission($name);
        if ($permission)
            $auth->remove($permission);

        return $this->redirect(['index']);
    }
}
