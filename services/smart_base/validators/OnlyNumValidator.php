<?php

namespace app\services\smart_base\validators;

class OnlyNumValidator extends DefaultValidator
{
    /**
     * @var string
     */
    public $regexp_rule = '/^[0-9]+$/';
}