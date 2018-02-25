<?php

namespace App\Services\v1;

use App\Models\Patient;
use App\Models\PatientDetail;

class PatientService extends BaseService
{
    private $supportedIncludes = array(
        'lastDetail' => 'detail'
    );
    private $clauseProperties = array(
        'id',
        'tax_code',
        'last_name',
        'first_name',
        'sex'
    );
    protected $rules = array(
        'last_name' => 'required|max:255',
        'first_name' => 'required|max:255',
        'tax_code' => 'required|size:16',
        'sex' => 'required|patient_sex',
        'birthday' => 'required|date|before:tomorrow|after:1900-01-01',
        'place_of_birth' => 'required|max:255',
        'detail.phone_number' => 'required|max:255',
        'detail.email' => 'email|max:255'
    );

    public function getPatients($parameters)
    {
        if (empty($parameters)) {
            $patients = $this->filterPatients(Patient::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $patients = Patient::with($withKeys)->where($whereClauses)->get();
            $patients = $this->filterPatients($patients, $withKeys);
        }

        return $patients;

    }

    public function createPatient($request)
    {
        $this->validate($request->all());

        $patient = new Patient();

        $patient->last_name = $request->input("last_name");
        $patient->first_name = $request->input("first_name");
        $patient->tax_code = $request->input("tax_code");
        $patient->sex = $request->input("sex");
        $patient->birthday = $request->input("birthday");
        $patient->place_of_birth = $request->input("place_of_birth");

        $patient->save();

        $detail = new PatientDetail();

        $detail->address = $request->input("detail.address");
        $detail->city = $request->input("detail.city");
        $detail->phone_number = $request->input("detail.phone_number");
        $detail->email = $request->input("detail.email");

        $patient->details()->save($detail);

        return $this->filterPatients(array($patient));
    }

    public function updatePatient($request, $id)
    {
        $this->validate($request->all());

        $patient = Patient::findOrFail($id);
        $patient->last_name = $request->input("last_name");
        $patient->first_name = $request->input("first_name");
        $patient->tax_code = $request->input("tax_code");
        $patient->sex = $request->input("sex");
        $patient->birthday = $request->input("birthday");
        $patient->place_of_birth = $request->input("place_of_birth");

        $patient->save();

        $detail = new PatientDetail();

        $detail->address = $request->input("detail.address");
        $detail->city = $request->input("detail.city");
        $detail->phone_number = $request->input("detail.phone_number");
        $detail->email = $request->input("detail.email");

        $patient->details()->save($detail);

        return $this->filterPatients(array($patient));
    }

    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->details()->delete();
        $patient->delete();
    }

    private function filterPatients($patients, $keys = array())
    {
        $data = array();

        foreach ($patients as $patient) {
            $birthday = date_create($patient->birthday);

            $item = array(
                'id' => $patient->id,
                'first_name' => $patient->first_name,
                'last_name' => $patient->last_name,
                'tax_code' => $patient->tax_code,
                'sex' => $patient->sex,
                'birthday' => $birthday->format('d-m-Y'),
                'place_of_birth' => $patient->place_of_birth,
                'href' => route('patients.show', ['id' => $patient->id])
            );

            if (in_array('lastDetail', $keys)) {
                if (isset($patient->lastDetail)) {
                    $item['detail'] = array(
                        'address' => $patient->lastDetail->address,
                        'city' => $patient->lastDetail->city,
                        'phone' => $patient->lastDetail->phone_number,
                        'email' => $patient->lastDetail->email
                    );
                } else {
                    $item['detail'] = array();
                }
            }

            $data[] = $item;
        }

        return $data;
    }

    private function getWithKeys($parameters)
    {
        $withKeys = array();

        if (isset($parameters['include'])) {
            $includeParams = explode(",", $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParams);
            $withKeys = array_keys($includes);
        }

        return $withKeys;

    }

    private function getWhereClause($parameters)
    {
        $clause = array();

        foreach ($this->clauseProperties as $property) {
            if (in_array($property, array_keys($parameters))) {
                $clause[$property] = $parameters[$property];
            }
        }

        return $clause;
    }
}