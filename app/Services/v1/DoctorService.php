<?php

namespace App\Services\v1;

use App\Models\Doctor;

class DoctorService extends BaseService
{
    /**
     * Construct the class and Dependency Injection.
     *
     */
    public function __construct()
    {
        $this->supportedIncludes = array(
            'discipline' => 'discipline'
        );
        $this->clauseProperties = array(
            'id',
            'last_name',
            'first_name',
            'enabled',
            'discipline_id'
        );
        $this->rules = array(
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'enabled' => 'required|boolean'
        );
    }

    public function getDoctors($parameters)
    {
        if (empty($parameters)) {
            $doctors = $this->filterDoctors(Doctor::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $doctors = Doctor::with($withKeys)->where($whereClauses)->get();
            $doctors = $this->filterDoctors($doctors, $withKeys);
        }

        return $doctors;
    }

    public function createDoctor($request)
    {
        $this->validate($request->all());

        $doctor = new doctor();

        $doctor->first_name = $request->input("first_name");
        $doctor->last_name = $request->input("last_name");
        $doctor->discipline_id = $request->input("discipline_id");
        $doctor->enabled = $request->input("enabled");
        $doctor->save();

        return $this->filterDoctors(array($doctor));
    }

    public function updateDoctor($request, $id)
    {
        $this->validate($request->all());

        $doctor = Doctor::findOrFail($id);
        $doctor->first_name = $request->input("first_name");
        $doctor->last_name = $request->input("last_name");
        $doctor->discipline_id = $request->input("discipline_id");
        $doctor->enabled = $request->input("enabled");

        $doctor->save();

        return $this->filterDoctors(array($doctor));
    }

    public function deleteDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
    }

    private function filterDoctors($doctors, $keys = array())
    {
        $data = array();

        foreach ($doctors as $doctor) {
            $item = array(
                'id' => $doctor->id,
                'last_name' => $doctor->last_name,
                'first_name' => $doctor->first_name,
                'enabled' => $doctor->enabled,
                'href' => route('doctors.show', ['id' => $doctor->id])
            );
            if (in_array('discipline', $keys)) {
                $item['discipline'] = array(
                    'id' => $doctor->discipline->id,
                    'description' => $doctor->discipline->description,
                    'enabled' => $doctor->discipline->enabled
                );
            }
            $data[] = $item;
        }

        return $data;
    }
}