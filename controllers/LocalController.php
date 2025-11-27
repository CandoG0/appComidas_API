<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\Cors;
use yii\data\ActiveDataProvider;

class LocalController extends ActiveController
{
    public $modelClass = 'app\models\Local';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Remove authentication behaviors for CORS
        unset($behaviors['authenticator']);

        // Enable CORS
        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        // Content negotiator
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Override the index action - MOSTRAR TODOS LOS LOCALES
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => function ($action) {
                $modelClass = $this->modelClass;
                $query = $modelClass::find()
                    ->orderBy(['loc_nombre' => SORT_ASC]); // Mostrar todos, sin filtro

                return new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => false,
                ]);
            },
        ];

        return $actions;
    }

    /**
     * Acción para buscar locales - SIN FILTRO loc_activo
     */
    public function actionSearch($q = '')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $modelClass = $this->modelClass;
        $query = $modelClass::find()
            ->where([
                'or',
                ['like', 'loc_nombre', $q],
                ['like', 'loc_descripcion', $q]
            ])
            ->orderBy(['loc_nombre' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $dataProvider->getModels();
    }

    /**
     * Acción para obtener un local por ID - SIN VERIFICACIÓN loc_activo
     */
    public function actionView($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        return $model;
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('El recurso solicitado no existe.');
    }

    /**
     * Manejar solicitudes OPTIONS para CORS
     */
    public function actionOptions()
    {
        \Yii::$app->response->statusCode = 200;
    }
}
