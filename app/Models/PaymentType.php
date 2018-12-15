<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends BaseModel
{
    /**
     * Get the payments.
     */
    public function payments()
    {
        return $this->hasMany('App\Models\PaymentType');
    }
}
