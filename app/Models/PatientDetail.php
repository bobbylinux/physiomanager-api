<?php

namespace App\Models;

class PatientDetail extends BaseModel
{
    /**
     * Get the patient basic information.
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
