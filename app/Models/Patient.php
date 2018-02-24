<?php

namespace App\Models;

class Patient extends BaseModel
{
    /**
     * Get the patient details.
     */
    public function details()
    {
        return $this->hasMany('App\Models\PatientDetail');
    }

    /**
     * Get the last patient details.
     */
    public function lastDetail()
    {
        return $this->hasOne('App\Models\PatientDetail')->orderBy('id','desc');
    }
}
