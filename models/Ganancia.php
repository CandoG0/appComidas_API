<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ganancia".
 *
 * @property int $gan_id
 * @property string $gan_total
 * @property int|null $gan_fkved_id
 *
 * @property VentaDetalle $ganFkved
 */
class Ganancia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ganancia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gan_fkved_id'], 'default', 'value' => null],
            [['gan_total'], 'required'],
            [['gan_fkved_id'], 'integer'],
            [['gan_total'], 'string', 'max' => 100],
            [['gan_fkved_id'], 'exist', 'skipOnError' => true, 'targetClass' => VentaDetalle::class, 'targetAttribute' => ['gan_fkved_id' => 'ved_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gan_id' => 'Gan ID',
            'gan_total' => 'Gan Total',
            'gan_fkved_id' => 'Gan Fkved ID',
        ];
    }

    /**
     * Gets query for [[GanFkved]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGanFkved()
    {
        return $this->hasOne(VentaDetalle::class, ['ved_id' => 'gan_fkved_id']);
    }

}
