<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property int $cat_id
 * @property string $cat_nombre
 * @property string|null $cat_descripcion
 *
 * @property Platillo[] $platillos
 */
class Categoria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_descripcion'], 'default', 'value' => null],
            [['cat_nombre'], 'required'],
            [['cat_descripcion'], 'string'],
            [['cat_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => 'Cat ID',
            'cat_nombre' => 'Cat Nombre',
            'cat_descripcion' => 'Cat Descripcion',
        ];
    }

    /**
     * Gets query for [[Platillos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatillos()
    {
        return $this->hasMany(Platillo::class, ['pla_fkcat_id' => 'cat_id']);
    }

}
