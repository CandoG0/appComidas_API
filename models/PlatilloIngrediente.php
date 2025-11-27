<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "platillo_ingrediente".
 *
 * @property int $pli_id
 * @property int $pli_fkpla_id
 * @property int $pli_fking_id
 *
 * @property Ingrediente $pliFking
 * @property Platillo $pliFkpla
 */
class PlatilloIngrediente extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'platillo_ingrediente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pli_fkpla_id', 'pli_fking_id'], 'required'],
            [['pli_fkpla_id', 'pli_fking_id'], 'integer'],
            [['pli_fking_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingrediente::class, 'targetAttribute' => ['pli_fking_id' => 'ing_id']],
            [['pli_fkpla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platillo::class, 'targetAttribute' => ['pli_fkpla_id' => 'pla_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pli_id' => 'Pli ID',
            'pli_fkpla_id' => 'Pli Fkpla ID',
            'pli_fking_id' => 'Pli Fking ID',
        ];
    }

    /**
     * Gets query for [[PliFking]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPliFking()
    {
        return $this->hasOne(Ingrediente::class, ['ing_id' => 'pli_fking_id']);
    }

    /**
     * Gets query for [[PliFkpla]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPliFkpla()
    {
        return $this->hasOne(Platillo::class, ['pla_id' => 'pli_fkpla_id']);
    }

}
