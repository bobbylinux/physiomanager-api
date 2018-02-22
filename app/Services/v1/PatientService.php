<?php

namespace App\Services\v1;

use App\Models\Patient;

class PatientService
{
    public function getPatients()
    {
        return Patient::all();
    }
}