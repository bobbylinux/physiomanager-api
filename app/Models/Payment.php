<?php

namespace App\Models;

class Payment extends BaseModel
{
    /**
     * Get the payment plan.
     */
    public function plan()
    {
        return $this->belongsTo('App\Models\Plan');
    }

    /**
     * Get the payment type.
     */
    public function payment_type()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }
}
