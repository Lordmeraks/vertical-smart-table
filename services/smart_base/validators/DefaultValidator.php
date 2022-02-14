<?php

namespace app\services\smart_base\validators;

class DefaultValidator implements SmartBaseValidator
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    public $regexp_rule = '/.|\R/';

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function validate()
    {
        return preg_match($this->regexp_rule, $this->value);
    }
}