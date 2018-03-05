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
            'description',
            'enabled',
            'price'
        );
        $this->rules = array(
            'description' => 'required|max:255',
            'enabled' => 'required|boolean',
            'price' => 'required|decimal|min:0'
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
                'description' => $plan->description,
                'enabled' => $plan->enabled,
                'price' => $plan->price,
                'href' => route('plans.show', ['id' => $plan->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}