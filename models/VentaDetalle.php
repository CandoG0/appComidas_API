<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venta_detalle".
 *
 * @property int $ved_id
 * @property int $ved_cantidad
 * @property float $ved_subtotal
 * @property int $ved_fkven_id
 * @property int $ved_fkpla_id
 *
 * @property Ganancia[] $ganancias
 * @property Platillo $vedFkpla
 * @property Venta $vedFkven
 */
class VentaDetalle extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venta_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ved_cantidad', 'ved_subtotal', 'ved_fkven_id', 'ved_fkpla_id'], 'required'],
            [['ved_cantidad', 'ved_fkven_id', 'ved_fkpla_id'], 'integer'],
            [['ved_subtotal'], 'number'],
            [['ved_fkpla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platillo::class, 'targetAttribute' => ['ved_fkpla_id' => 'pla_id']],
            [['ved_fkven_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venta::class, 'targetAttribute' => ['ved_fkven_id' => 'ven_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ved_id' => 'Ved ID',
            'ved_cantidad' => 'Ved Cantidad',
            'ved_subtotal' => 'Ved Subtotal',
            'ved_fkven_id' => 'Ved Fkven ID',
            'ved_fkpla_id' => 'Ved Fkpla ID',
        ];
    }

    /**
     * Gets query for [[Ganancias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGanancias()
    {
        return $this->hasMany(Ganancia::class, ['gan_fkved_id' => 'ved_id']);
    }

    /**
     * Gets query for [[VedFkpla]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVedFkpla()
    {
        return $this->hasOne(Platillo::class, ['pla_id' => 'ved_fkpla_id']);
    }

    /**
     * Gets query for [[VedFkven]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVedFkven()
    {
        return $this->hasOne(Venta::class, ['ven_id' => 'ved_fkven_id']);
    }

}
