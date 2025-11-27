<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puesto".
 *
 * @property int $pue_id
 * @property string $pue_nombre
 * @property float $pue_salario
 *
 * @property Empleado[] $empleados
 */
class Puesto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'puesto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pue_nombre', 'pue_salario'], 'required'],
            [['pue_salario'], 'number'],
            [['pue_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pue_id' => 'Pue ID',
            'pue_nombre' => 'Pue Nombre',
            'pue_salario' => 'Pue Salario',
        ];
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::class, ['emp_fkpue_id' => 'pue_id']);
    }

}
