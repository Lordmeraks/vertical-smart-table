<?php

namespace app\services\smart_base\validators;

interface SmartBaseValidator
{
    public function __construct(string $value);
    public function validate();
}