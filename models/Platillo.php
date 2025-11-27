<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "platillo".
 *
 * @property int $pla_id
 * @property string $pla_nombre
 * @property string|null $pla_descripcion
 * @property int $pla_stock
 * @property float $pla_precio
 * @property string $pla_fecha_creacion
 * @property int $pla_fkcat_id
 * @property int $pla_fkloc_id
 * @property int|null $pla_fkarc_id
 *
 * @property Archivo $plaFkarc
 * @property Categoria $plaFkcat
 * @property Local $plaFkloc
 * @property PlatilloIngrediente[] $platilloIngredientes
 * @property VentaDetalle[] $ventaDetalles
 */
class Platillo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'platillo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pla_descripcion', 'pla_fkarc_id'], 'default', 'value' => null],
            [['pla_nombre', 'pla_stock', 'pla_precio', 'pla_fecha_creacion', 'pla_fkcat_id', 'pla_fkloc_id'], 'required'],
            [['pla_descripcion'], 'string'],
            [['pla_stock', 'pla_fkcat_id', 'pla_fkloc_id', 'pla_fkarc_id'], 'integer'],
            [['pla_precio'], 'number'],
            [['pla_fecha_creacion'], 'safe'],
            [['pla_nombre'], 'string', 'max' => 100],
            [['pla_fkarc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Archivo::class, 'targetAttribute' => ['pla_fkarc_id' => 'arc_id']],
            [['pla_fkcat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['pla_fkcat_id' => 'cat_id']],
            [['pla_fkloc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Local::class, 'targetAttribute' => ['pla_fkloc_id' => 'loc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pla_id' => 'Pla ID',
            'pla_nombre' => 'Pla Nombre',
            'pla_descripcion' => 'Pla Descripcion',
            'pla_stock' => 'Pla Stock',
            'pla_precio' => 'Pla Precio',
            'pla_fecha_creacion' => 'Pla Fecha Creacion',
            'pla_fkcat_id' => 'Pla Fkcat ID',
            'pla_fkloc_id' => 'Pla Fkloc ID',
            'pla_fkarc_id' => 'Pla Fkarc ID',
        ];
    }

    /**
     * Gets query for [[PlaFkarc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaFkarc()
    {
        return $this->hasOne(Archivo::class, ['arc_id' => 'pla_fkarc_id']);
    }

    /**
     * Gets query for [[PlaFkcat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaFkcat()
    {
        return $this->hasOne(Categoria::class, ['cat_id' => 'pla_fkcat_id']);
    }

    /**
     * Gets query for [[PlaFkloc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaFkloc()
    {
        return $this->hasOne(Local::class, ['loc_id' => 'pla_fkloc_id']);
    }

    /**
     * Gets query for [[PlatilloIngredientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatilloIngredientes()
    {
        return $this->hasMany(PlatilloIngrediente::class, ['pli_fkpla_id' => 'pla_id']);
    }

    /**
     * Gets query for [[VentaDetalles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentaDetalles()
    {
        return $this->hasMany(VentaDetalle::class, ['ved_fkpla_id' => 'pla_id']);
    }

}
