<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    /**
     * Get the patient by detail.
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\PatientDetail');
    }
}
