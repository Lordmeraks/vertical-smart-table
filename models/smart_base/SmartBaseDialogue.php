<?php

namespace app\models\smart_base;

/**
 *
 * @property int $id [int]
 * @property string $user_id [int unsigned]
 * @property int $created_at [timestamp]
 */
class SmartBaseDialogue extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'smart_base_dialogue';
    }

    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['created_at'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ записи',
            'user_id' => 'Кем создано',
            'updated_at' => 'Дата обновления',
        ];
    }
}