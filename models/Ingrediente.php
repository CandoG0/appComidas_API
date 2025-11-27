<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingrediente".
 *
 * @property int $ing_id
 * @property string $ing_nombre
 * @property string|null $ing_descripcion
 *
 * @property PlatilloIngrediente[] $platilloIngredientes
 */
class Ingrediente extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingrediente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ing_descripcion'], 'default', 'value' => null],
            [['ing_nombre'], 'required'],
            [['ing_descripcion'], 'string'],
            [['ing_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ing_id' => 'Ing ID',
            'ing_nombre' => 'Ing Nombre',
            'ing_descripcion' => 'Ing Descripcion',
        ];
    }

    /**
     * Gets query for [[PlatilloIngredientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatilloIngredientes()
    {
        return $this->hasMany(PlatilloIngrediente::class, ['pli_fking_id' => 'ing_id']);
    }

}
