<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empleado".
 *
 * @property int $emp_id
 * @property string $emp_nombre
 * @property string $emp_paterno
 * @property string $emp_materno
 * @property string|null $emp_telefono
 * @property int $emp_comision
 * @property string $emp_hora_entrada
 * @property string $emp_hora_salida
 * @property string $emp_fecha_nacimiento
 * @property string $emp_fecha_alta
 * @property string|null $emp_fecha_baja
 * @property string|null $emp_dom
 * @property int $emp_fkpue_id
 * @property int $emp_fkarc_id
 * @property int $emp_fkloc_id
 *
 * @property Archivo $empFkarc
 * @property Local $empFkloc
 * @property Puesto $empFkpue
 */
class Empleado extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empleado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_telefono', 'emp_fecha_baja', 'emp_dom'], 'default', 'value' => null],
            [['emp_nombre', 'emp_paterno', 'emp_materno', 'emp_comision', 'emp_hora_entrada', 'emp_hora_salida', 'emp_fecha_nacimiento', 'emp_fecha_alta', 'emp_fkpue_id', 'emp_fkarc_id', 'emp_fkloc_id'], 'required'],
            [['emp_comision', 'emp_fkpue_id', 'emp_fkarc_id', 'emp_fkloc_id'], 'integer'],
            [['emp_hora_entrada', 'emp_hora_salida', 'emp_fecha_nacimiento', 'emp_fecha_alta', 'emp_fecha_baja'], 'safe'],
            [['emp_nombre', 'emp_paterno', 'emp_materno'], 'string', 'max' => 50],
            [['emp_telefono'], 'string', 'max' => 20],
            [['emp_dom'], 'string', 'max' => 100],
            [['emp_fkarc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Archivo::class, 'targetAttribute' => ['emp_fkarc_id' => 'arc_id']],
            [['emp_fkloc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Local::class, 'targetAttribute' => ['emp_fkloc_id' => 'loc_id']],
            [['emp_fkpue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::class, 'targetAttribute' => ['emp_fkpue_id' => 'pue_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'emp_nombre' => 'Emp Nombre',
            'emp_paterno' => 'Emp Paterno',
            'emp_materno' => 'Emp Materno',
            'emp_telefono' => 'Emp Telefono',
            'emp_comision' => 'Emp Comision',
            'emp_hora_entrada' => 'Emp Hora Entrada',
            'emp_hora_salida' => 'Emp Hora Salida',
            'emp_fecha_nacimiento' => 'Emp Fecha Nacimiento',
            'emp_fecha_alta' => 'Emp Fecha Alta',
            'emp_fecha_baja' => 'Emp Fecha Baja',
            'emp_dom' => 'Emp Dom',
            'emp_fkpue_id' => 'Emp Fkpue ID',
            'emp_fkarc_id' => 'Emp Fkarc ID',
            'emp_fkloc_id' => 'Emp Fkloc ID',
        ];
    }

    /**
     * Gets query for [[EmpFkarc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpFkarc()
    {
        return $this->hasOne(Archivo::class, ['arc_id' => 'emp_fkarc_id']);
    }

    /**
     * Gets query for [[EmpFkloc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpFkloc()
    {
        return $this->hasOne(Local::class, ['loc_id' => 'emp_fkloc_id']);
    }

    /**
     * Gets query for [[EmpFkpue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpFkpue()
    {
        return $this->hasOne(Puesto::class, ['pue_id' => 'emp_fkpue_id']);
    }

}
