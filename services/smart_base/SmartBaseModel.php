<?php

namespace app\services\smart_base;

use app\controllers\smart_base\FormController;
use app\models\smart_base\SmartBase;
use app\models\smart_base\SmartBaseDialogue;
use yii\helpers\Json;

class SmartBaseModel implements SmartModel
{

    /**
     * @var array
     */
    private $data;
    /**
     * @var string
     */
    private $number;
    /**
     * @var SmartBaseDialogue
     */
    private $dialogue;

    /**
     * @var array
     */
    public $errors = [];
    /**
     * @var array
     */
    private $old_data;

    public function __construct(array $data, string $number, SmartBaseDialogue $dialogue)
    {
        $this->data = $data;
        $this->number = $number;
        $this->dialogue = $dialogue;
        $client_data = Json::decode(FormController::getClientData());
        $this->old_data = [];
        if (is_array($client_data)) {
            if (count($client_data) > 0) {
                foreach ($client_data as $item) {
                    $this->old_data[$item['field']] = $item['value'];
                }
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->data as $row) {
            if ($row['value'] !== $this->old_data[$row['field']] && trim($row['value']) !== '') {
                $validators = new ValidatorsByType($row['type'], $row['value']);
                $validate = $validators->getValidator()->validate();
                if (!$validate) {
                    $this->errors[] = [
                        'field' => $row['field'],
                        'message' => '  Указаны не корректные данные или недопустимые символы',
                    ];
                }
            }
        }
        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    public function save(): bool
    {
        foreach ($this->data as $row) {
            if ($row['value'] !== $this->old_data[$row['field']] && trim($row['value']) !== '') {
                $item = new SmartBase();
                $item->dialogue_id = $this->dialogue->id;
                $item->field = $row['field'];
                $item->value = trim($row['value']);
                $item->client_number = $this->number;
                $item->save();
            }
        }

        return true;
    }
}