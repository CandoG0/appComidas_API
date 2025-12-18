<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use yii\web\Controller;

class CategoriaController extends Controller
{
    /**
     * API: Obtener todas las categorías
     */
    public function actionApiTodas()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Configurar CORS
        $headers = Yii::$app->response->headers;
        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $headers->set('Access-Control-Allow-Headers', 'Content-Type');
        
        try {
            $categorias = Categoria::find()
                ->asArray()
                ->all();
                
            return [
                'success' => true,
                'data' => $categorias,
                'count' => count($categorias),
            ];
            
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Error al obtener categorías',
                'error' => $e->getMessage(),
            ];
        }
    }
}