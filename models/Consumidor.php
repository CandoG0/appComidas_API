<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consumidor".
 *
 * @property int $con_id
 * @property string $con_nombre
 * @property string $con_paterno
 * @property string $con_materno
 * @property string|null $con_telefono
 * @property string $con_correo
 * @property string $con_fecha_registro
 *
 * @property Local[] $locals
 * @property Venta[] $ventas
 */
class Consumidor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consumidor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['con_telefono'], 'default', 'value' => null],
            [['con_nombre', 'con_paterno', 'con_materno', 'con_correo', 'con_fecha_registro'], 'required'],
            [['con_fecha_registro'], 'safe'],
            [['con_nombre', 'con_paterno', 'con_materno', 'con_correo'], 'string', 'max' => 50],
            [['con_telefono'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'con_id' => 'Con ID',
            'con_nombre' => 'Con Nombre',
            'con_paterno' => 'Con Paterno',
            'con_materno' => 'Con Materno',
            'con_telefono' => 'Con Telefono',
            'con_correo' => 'Con Correo',
            'con_fecha_registro' => 'Con Fecha Registro',
        ];
    }

    /**
     * Gets query for [[Locals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocals()
    {
        return $this->hasMany(Local::class, ['loc_fkcon_id' => 'con_id']);
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['ven_fkcon_id' => 'con_id']);
    }

}
