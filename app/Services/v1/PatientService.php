<?php

namespace App\Services\v1;

use App\Models\Patient;

class PatientService
{
    public function getPatients()
    {
        return $this->filterPatients(Patient::all());
    }

    private function filterPatients($patients)
    {
        $data = array();

        foreach ($patients as $patient) {
            $birthday = date_create($patient->date_of_birth);

            $item = array(
                'id' => $patient->id,
                'name' => $patient->first_name,
                'surname' => $patient->last_name,
                'tax_code' => $patient->tax_code,
                'sex' => $patient->sex,
                'birthday' => $birthday->format('d-m-Y'),
                'city_of_birth' => $patient->city_of_birth,
                'href' => route('patients.show',['id' => $patient->id])
            );

            $data[]=$item;
        }

        return $data;
    }
}