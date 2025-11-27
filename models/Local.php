<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "local".
 *
 * @property int $loc_id
 * @property string $loc_nombre
 * @property string|null $loc_descripcion
 * @property string|null $loc_telefono
 * @property string $loc_inicio
 * @property string $loc_final
 * @property string $loc_titular
 * @property int $loc_cuenta
 * @property string $loc_banco
 * @property string $loc_fecha_creacion
 * @property int $loc_fkcon_id
 * @property string|null $loc_domicilio
 *
 * @property Empleado[] $empleados
 * @property Consumidor $locFkcon
 * @property Platillo[] $platillos
 * @property Venta[] $ventas
 */
class Local extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'local';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loc_descripcion', 'loc_telefono', 'loc_domicilio'], 'default', 'value' => null],
            [['loc_nombre', 'loc_inicio', 'loc_final', 'loc_titular', 'loc_cuenta', 'loc_banco', 'loc_fecha_creacion', 'loc_fkcon_id'], 'required'],
            [['loc_descripcion'], 'string'],
            [['loc_inicio', 'loc_final', 'loc_fecha_creacion'], 'safe'],
            [['loc_cuenta', 'loc_fkcon_id'], 'integer'],
            [['loc_nombre', 'loc_titular', 'loc_domicilio'], 'string', 'max' => 255],
            [['loc_telefono'], 'string', 'max' => 20],
            [['loc_banco'], 'string', 'max' => 100],
            [['loc_fkcon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consumidor::class, 'targetAttribute' => ['loc_fkcon_id' => 'con_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'loc_id' => 'Loc ID',
            'loc_nombre' => 'Loc Nombre',
            'loc_descripcion' => 'Loc Descripcion',
            'loc_telefono' => 'Loc Telefono',
            'loc_inicio' => 'Loc Inicio',
            'loc_final' => 'Loc Final',
            'loc_titular' => 'Loc Titular',
            'loc_cuenta' => 'Loc Cuenta',
            'loc_banco' => 'Loc Banco',
            'loc_fecha_creacion' => 'Loc Fecha Creacion',
            'loc_fkcon_id' => 'Loc Fkcon ID',
            'loc_domicilio' => 'Loc Domicilio',
        ];
    }

    /**
     * Campos que se devolverán en las respuestas JSON
     */
    public function fields()
    {
        return [
            'loc_id',
            'loc_nombre',
            'loc_descripcion',
            'loc_telefono',
            'loc_inicio' => function ($model) {
                return date('H:i', strtotime($model->loc_inicio));
            },
            'loc_final' => function ($model) {
                return date('H:i', strtotime($model->loc_final));
            },
            'loc_titular',
            'loc_cuenta',
            'loc_banco',
            'loc_fecha_creacion',
            'loc_fkcon_id',
            'loc_domicilio',
        ];
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::class, ['emp_fkloc_id' => 'loc_id']);
    }

    /**
     * Gets query for [[LocFkcon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocFkcon()
    {
        return $this->hasOne(Consumidor::class, ['con_id' => 'loc_fkcon_id']);
    }

    /**
     * Gets query for [[Platillos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatillos()
    {
        return $this->hasMany(Platillo::class, ['pla_fkloc_id' => 'loc_id']);
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['ven_fkloc_id' => 'loc_id']);
    }
}
