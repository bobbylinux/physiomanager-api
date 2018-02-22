<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
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
