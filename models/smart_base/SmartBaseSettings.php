<?php

namespace app\models\smart_base;

/**
 *
 * @property int $id [int]
 * @property string $created_by [int unsigned]
 * @property int $created_at [timestamp]
 * @property int $updated_at [timestamp]
 * @property string $settings [json]
 */
class SmartBaseSettings extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'smart_base_settings';
    }

    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['settings'],'string'],
            [['created_at','updated_at'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ записи',
            'created_by' => 'Кем создано',
            'settings' => 'Настройки',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}