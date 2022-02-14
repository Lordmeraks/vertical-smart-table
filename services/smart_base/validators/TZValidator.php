<?php

namespace app\services\smart_base\validators;

use app\services\checktz\Legaltz;

class TZValidator extends DefaultValidator
{
    public function validate()
    {
        if (strlen($this->value) === 9) {
            $checkTZ = new Legaltz();
            return $checkTZ->CheckTz($this->value);
        }
        return false;
    }
}