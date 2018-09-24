<?php

namespace App\Services\v1;

use App\Models\Plan;

class PlanService extends BaseService
{

    /**
     * Construct the class.
     *
     */
    public function __construct()
    {
        $this->supportedIncludes = array(
            'sessions' => 'sessions',
            'mobility' => 'mobility',
            'pain' => 'pain',
            'work_result' => 'work_result',
            'patient' => 'patient'
        );

        $this->clauseProperties = array(
            'id',
            'patient_id'
        );
        $this->rules = array(
            'patient_id' => 'required'
        );
    }

    public function getPlans($parameters)
    {
        if (empty($parameters)) {
            $plans = $this->filterPlans(Plan::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $plans = Plan::with($withKeys)->where($whereClauses)->get();
            $plans = $this->filterPlans($plans, $withKeys);
        }

        return $plans;
    }

    public function createPlan($request)
    {
        $this->validate($request->all());

        $plan = new Plan();

        $plan->patient_id = $request->input("patient_id");
        $plan->pathological_conditions = $request->input("pathological_conditions");
        $plan->note = $request->input("note");
        $plan->final_report = $request->input("final_report");
        $plan->privacy = $request->input("privacy");
        $plan->medical_certificate = $request->input("medical_certificate");
        $plan->work_result_id = $request->input("work_result_id");
        $plan->pain_id = $request->input("pain_id");
        $plan->mobility_id = $request->input("mobility_id");
        $plan->save();

        return $this->filterPlans(array($plan));
    }

    public function updatePlan($request, $id)
    {
        $this->validate($request->all());

        $plan = Plan::findOrFail($id);
        $plan->pathological_conditions = $request->input("pathological_conditions");
        $plan->note = $request->input("note");
        $plan->final_report = $request->input("final_report");
        $plan->privacy = $request->input("privacy");
        $plan->medical_certificate = $request->input("medical_certificate");
        $plan->work_result_id = $request->input("work_result_id");
        $plan->pain_id = $request->input("pain_id");
        $plan->mobility_id = $request->input("mobility_id");

        $plan->save();

        return $this->filterPlans(array($plan));
    }

    public function deletePlan($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
    }

    private function filterPlans($plans, $keys = array())
    {
        $data = array();

        foreach ($plans as $plan) {
            $item = array(
                'id' => $plan->id,
                'patient_id' => $plan->patient_id,
                'pathological_conditions' => $plan->pathological_conditions,
                'note' => $plan->note,
                'final_report' => $plan->final_report,
                'privacy' => $plan->privacy,
                'pain_id' => $plan->pain_id,
                'mobility_id' => $plan->mobility_id,
                'work_result_id' => $plan->work_result_id,
                'program' => $plan->program,
                'medical_certificate' => $plan->medical_certificate,
                'href' => route('plans.show', ['id' => $plan->id])
            );

            if (in_array('sessions', $keys)) {
                if (isset($plan->sessions)) {
                    foreach ($plan->sessions as $session) {
                        $item['sessions'][] = array(
                            'id' => $session->id,
                            'date' => $session->date,
                            'therapy_id' => $session->therapy_id,
                            'therapy' => array(
                                'id' =>  $session->therapy->id,
                                'description' => $session->therapy->description
                            ),
                            'physiotherapist_id' => $session->physiotherapist_id,
                            'physiotherapist' => array(
                                'id' => $session->physiotherapist->id,
                                'last_name' => $session->physiotherapist->last_name,
                                'first_name' => $session->physiotherapist->first_name
                            ),
                            'price' => $session->price,
                            'units' => $session->units
                        );
                    }
                } else {
                    $item['sessions'] = array();
                }
            }

            if (in_array('mobility', $keys)) {
                if (isset($plan->mobility)) {
                    $item['mobility'] = array(
                        'id' => $plan->mobility->id,
                        'decription' => $plan->mobility->description
                    );
                } else {
                    $item['mobility'] = array();
                }
            }

            if (in_array('pain', $keys)) {
                if (isset($plan->pain)) {
                    $item['pain'] = array(
                        'id' => $plan->pain->id,
                        'decription' => $plan->pain->description
                    );
                } else {
                    $item['pain'] = array();
                }
            }

            if (in_array('work_result', $keys)) {
                if (isset($plan->pain)) {
                    $item['work_result'] = array(
                        'id' => $plan->work_result->id,
                        'decription' => $plan->work_result->description
                    );
                } else {
                    $item['work_result'] = array();
                }
            }

            if (in_array('patient', $keys)) {
                if (isset($plan->patient)) {
                    $item['patient'] = array(
                        'id' => $plan->patient->id,
                        'last_name' => $plan->patient->last_name,
                        'first_name' => $plan->patient->first_name,
                        'tax_code' => $plan->patient->tax_code,
                        'sex' => $plan->patient->sex,
                        'birthday' => $plan->patient->birthday,
                        'place_of_birth' => $plan->patient->place_of_birth
                    );
                } else {
                    $item['patient'] = array();
                }
            }
            $data[] = $item;

        }

        return $data;
    }
}