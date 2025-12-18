<?php

namespace app\controllers;

use Yii;
use app\models\Platillo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * PlatilloController implementa acciones para el modelo Platillo.
 */
class PlatilloController extends Controller
{
    /**
     * API: Obtener platillos por ID de local
     */
    public function actionApiPorLocal($local_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Configurar CORS si es necesario
        $headers = Yii::$app->response->headers;
        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $headers->set('Access-Control-Allow-Headers', 'Content-Type');
        
        try {
            $platillos = Platillo::find()
                ->where(['pla_fkloc_id' => $local_id])
                ->with(['categoria', 'local'])
                ->asArray()
                ->all();
                
            // Formatear la respuesta para Flutter
            $formattedData = array_map(function($platillo) {
                return [
                    'pla_id' => $platillo['pla_id'],
                    'title' => $platillo['pla_nombre'],
                    'description' => $platillo['pla_descripcion'],
                    'price' => number_format($platillo['pla_precio'], 2),
                    'stock' => $platillo['pla_stock'],
                    'category' => $platillo['categoria']['cat_nombre'] ?? 'Sin categoría',
                    'category_id' => $platillo['categoria']['cat_id'] ?? null,
                    'local_name' => $platillo['local']['loc_nombre'] ?? 'Sin local',
                    'image' => $platillo['archivo']['arc_ruta'] ?? 'https://via.placeholder.com/300x200/FF724C/FFFFFF?text=' . urlencode($platillo['pla_nombre']),
                    'created_at' => $platillo['pla_fecha_creacion'],
                ];
            }, $platillos);
            
            return [
                'success' => true,
                'data' => $formattedData,
                'count' => count($platillos),
                'local_id' => $local_id,
            ];
            
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Error al obtener platillos',
                'error' => $e->getMessage(),
            ];
        }
    }
}