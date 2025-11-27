<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivo".
 *
 * @property int $arc_id
 * @property string $arc_nombre
 * @property string $arc_tipo
 * @property string $arc_ruta
 * @property string $arc_fecha_subida
 * @property int $arc_tamanio
 *
 * @property Empleado[] $empleados
 * @property Platillo[] $platillos
 */
class Archivo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['arc_nombre', 'arc_tipo', 'arc_ruta', 'arc_fecha_subida', 'arc_tamanio'], 'required'],
            [['arc_ruta'], 'string'],
            [['arc_fecha_subida'], 'safe'],
            [['arc_tamanio'], 'integer'],
            [['arc_nombre'], 'string', 'max' => 100],
            [['arc_tipo'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'arc_id' => 'Arc ID',
            'arc_nombre' => 'Arc Nombre',
            'arc_tipo' => 'Arc Tipo',
            'arc_ruta' => 'Arc Ruta',
            'arc_fecha_subida' => 'Arc Fecha Subida',
            'arc_tamanio' => 'Arc Tamanio',
        ];
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::class, ['emp_fkarc_id' => 'arc_id']);
    }

    /**
     * Gets query for [[Platillos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatillos()
    {
        return $this->hasMany(Platillo::class, ['pla_fkarc_id' => 'arc_id']);
    }

}
