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
        $this->clauseProperties = array(
            'id',
            'patient_id'
        );
        $this->rules = array(
            'description' => 'required|max:255',
            'enabled' => 'required|boolean',
            'price' => 'required|decimal|min:0',
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

        $plan->description = $request->input("description");
        $plan->enabled = $request->input("enabled");
        $plan->price = $request->input("price");
        $plan->save();

        return $this->filterPlans(array($plan));
    }

    public function updatePlan($request, $id)
    {
        $this->validate($request->all());

        $plan = Plan::findOrFail($id);
        $plan->description = $request->input("description");
        $plan->enabled = $request->input("enabled");
        $plan->price = $request->input("price");

        $plan->save();

        return $this->filterPlans(array($plan));
    }

    public function deletePlan($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
    }

    private function filterPlans($plans)
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
                'medical_certificate' => $plan->medical_certificate,
                'href' => route('plans.show', ['id' => $plan->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}