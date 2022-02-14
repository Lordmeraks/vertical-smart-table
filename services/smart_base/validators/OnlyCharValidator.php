<?php

namespace app\services\smart_base\validators;

use yii\validators\RegularExpressionValidator;

class OnlyCharValidator extends DefaultValidator
{
    /**
     * @var string
     */
    public $regexp_rule = '/^[a-zA-Z\x{0430}-\x{044F}\x{0410}-\x{042F} -]+$/u';
}