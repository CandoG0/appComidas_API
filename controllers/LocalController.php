<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Local; // Si tienes el modelo

class LocalController extends Controller
{
    public function actionIndex()
    {
        // Headers CORS
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
        Yii::$app->response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
        
        // Si es OPTIONS, responder preflight
        if (Yii::$app->request->method === 'OPTIONS') {
            Yii::$app->response->statusCode = 200;
            return '';
        }
        
        // Formato JSON
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // Obtener todos los locales directamente
        $locales = Local::find()->all();
        
        // Convertir a array simple
        $result = [];
        foreach ($locales as $local) {
            $result[] = $local->attributes;
        }
        
        return $result;
    }
}