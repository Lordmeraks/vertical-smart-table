<?php

namespace app\services\smart_base;

use app\models\smart_base\SmartBaseDialogue;

interface SmartModel
{
    public function __construct(array $data, string $number, SmartBaseDialogue $dialogue);

    public function validate(): bool;

    public function save(): bool;
}