<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venta".
 *
 * @property int $ven_id
 * @property string $ven_fecha_venta
 * @property string $ven_estatus
 * @property int $ven_fkcon_id
 * @property int $ven_fkloc_id
 *
 * @property Consumidor $venFkcon
 * @property Local $venFkloc
 * @property VentaDetalle[] $ventaDetalles
 */
class Venta extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const VEN_ESTATUS_PENDIENTE = 'pendiente';
    const VEN_ESTATUS_ACEPTADO = 'aceptado';
    const VEN_ESTATUS_ENTREGADO = 'entregado';
    const VEN_ESTATUS_CANCELADO = 'cancelado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ven_estatus'], 'default', 'value' => 'pendiente'],
            [['ven_fecha_venta', 'ven_fkcon_id', 'ven_fkloc_id'], 'required'],
            [['ven_fecha_venta'], 'safe'],
            [['ven_estatus'], 'string'],
            [['ven_fkcon_id', 'ven_fkloc_id'], 'integer'],
            ['ven_estatus', 'in', 'range' => array_keys(self::optsVenEstatus())],
            [['ven_fkcon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consumidor::class, 'targetAttribute' => ['ven_fkcon_id' => 'con_id']],
            [['ven_fkloc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Local::class, 'targetAttribute' => ['ven_fkloc_id' => 'loc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ven_id' => 'Ven ID',
            'ven_fecha_venta' => 'Ven Fecha Venta',
            'ven_estatus' => 'Ven Estatus',
            'ven_fkcon_id' => 'Ven Fkcon ID',
            'ven_fkloc_id' => 'Ven Fkloc ID',
        ];
    }

    /**
     * Gets query for [[VenFkcon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenFkcon()
    {
        return $this->hasOne(Consumidor::class, ['con_id' => 'ven_fkcon_id']);
    }

    /**
     * Gets query for [[VenFkloc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenFkloc()
    {
        return $this->hasOne(Local::class, ['loc_id' => 'ven_fkloc_id']);
    }

    /**
     * Gets query for [[VentaDetalles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentaDetalles()
    {
        return $this->hasMany(VentaDetalle::class, ['ved_fkven_id' => 'ven_id']);
    }


    /**
     * column ven_estatus ENUM value labels
     * @return string[]
     */
    public static function optsVenEstatus()
    {
        return [
            self::VEN_ESTATUS_PENDIENTE => 'pendiente',
            self::VEN_ESTATUS_ACEPTADO => 'aceptado',
            self::VEN_ESTATUS_ENTREGADO => 'entregado',
            self::VEN_ESTATUS_CANCELADO => 'cancelado',
        ];
    }

    /**
     * @return string
     */
    public function displayVenEstatus()
    {
        return self::optsVenEstatus()[$this->ven_estatus];
    }

    /**
     * @return bool
     */
    public function isVenEstatusPendiente()
    {
        return $this->ven_estatus === self::VEN_ESTATUS_PENDIENTE;
    }

    public function setVenEstatusToPendiente()
    {
        $this->ven_estatus = self::VEN_ESTATUS_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isVenEstatusAceptado()
    {
        return $this->ven_estatus === self::VEN_ESTATUS_ACEPTADO;
    }

    public function setVenEstatusToAceptado()
    {
        $this->ven_estatus = self::VEN_ESTATUS_ACEPTADO;
    }

    /**
     * @return bool
     */
    public function isVenEstatusEntregado()
    {
        return $this->ven_estatus === self::VEN_ESTATUS_ENTREGADO;
    }

    public function setVenEstatusToEntregado()
    {
        $this->ven_estatus = self::VEN_ESTATUS_ENTREGADO;
    }

    /**
     * @return bool
     */
    public function isVenEstatusCancelado()
    {
        return $this->ven_estatus === self::VEN_ESTATUS_CANCELADO;
    }

    public function setVenEstatusToCancelado()
    {
        $this->ven_estatus = self::VEN_ESTATUS_CANCELADO;
    }
}
