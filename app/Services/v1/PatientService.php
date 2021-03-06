<?php

namespace App\Services\v1;

use App\Models\Patient;
use App\Models\PatientDetail;

class PatientService extends BaseService
{
    /**
     * Construct the class.
     *
     */
    public function __construct()
    {
        $this->supportedIncludes = array(
            'lastDetail' => 'detail',
            'plans' => 'plans'
        );
        $this->clauseProperties = array(
            'id',
            'tax_code',
            'last_name',
            'first_name'
        );
        $this->rules = array(
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'tax_code' => 'size:16',
            'place_of_birth' => 'max:255',
            'detail.phone_number' => 'required|max:255',
            'detail.email' => 'nullable|email|max:255'
        );
    }

    public function getPatients($parameters)
    {
        if (empty($parameters)) {
            $patients = $this->filterPatients(Patient::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters, TRUE);
            $patients = Patient::with($withKeys)->where($whereClauses)->orderBy('last_name')->orderBy('first_name')->get();
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
        $patient->birthday = $request->input("birthday");
        $patient->place_of_birth = $request->input("place_of_birth");

        $patient->save();

        $detail = new PatientDetail();

        $detail->doctor_id = $request->input("detail.doctor_id");
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
        $patient->birthday = $request->input("birthday");
        $patient->place_of_birth = $request->input("place_of_birth");

        $patient->save();

        $detail = new PatientDetail();

        $detail->doctor_id = $request->input("detail.doctor_id");
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
                'birthday' => $birthday->format('d-m-Y'),
                'place_of_birth' => $patient->place_of_birth,
                'href' => route('patients.show', ['id' => $patient->id])
            );

            if (in_array('lastDetail', $keys)) {
                if (isset($patient->lastDetail)) {
                    $item['detail'] = array(
                        'doctor_id' => $patient->lastDetail->doctor_id,
                        'address' => $patient->lastDetail->address,
                        'city' => $patient->lastDetail->city,
                        'phone_number' => $patient->lastDetail->phone_number,
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
}