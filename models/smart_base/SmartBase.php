<?php

namespace app\models\smart_base;

use app\models\CrmUsers;

/**
 *
 * @property int $id [int]
 * @property string $field [varchar(255)]
 * @property string $value [varchar(255)]
 * @property string $client_number [varchar(255)]
 * @property int $dialogue_id [int]
 */
class SmartBase extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'smart_base';
    }

    public function rules()
    {
        return [
            [['id', 'dialogue_id'], 'integer'],
            [['field','value','client_number'],'string','max'=>100,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ записи',
            'field' => 'Поле',
            'value' => 'Значение',
            'client_number' => 'Номер Клиента',
            'dialogue_id' => '№ диалога',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogue(): \yii\db\ActiveQuery
    {
        return $this->hasOne(SmartBaseDialogue::class, ['id' => 'dialogue_id'])->alias('sbd');
    }

    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(CrmUsers::class, ['id' => 'user_id'])->viaTable(SmartBaseDialogue::tableName(), ['id' => 'dialogue_id'])->alias('cu');
    }
}