<?php

namespace app\services\smart_base\validators;

class EmailValidator extends DefaultValidator
{
    /**
     * @var string
     */
    public $regexp_rule = '/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/';
}