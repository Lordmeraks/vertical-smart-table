<?php

namespace app\services\smart_base;

use app\controllers\smart_base\SettingsController;
use app\services\smart_base\validators\SmartBaseValidator;

class ValidatorsByType
{
    /**
     * @var SmartBaseValidator
     */
    private $validator;

    public function __construct(string $type, string $value)
    {
        $types = SettingsController::TYPES;
        $this->validator = new $types[$type]['validator']($value);
    }

    public function getValidator(): SmartBaseValidator
    {
        return $this->validator;
    }
}