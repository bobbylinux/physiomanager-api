<?php
namespace App\Services\v1;

use Validator;

abstract class BaseService
{
    public function validate($item) {
        $validator = Validator::make($item, $this->rules);
        $validator->validate();
    }

}