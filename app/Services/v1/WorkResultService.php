<?php
namespace App\Services\v1;

use App\Models\WorkResult;

class WorkResultService extends BaseService
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
            'enabled'
        );
        $this->rules = array(
            'description' => 'required|max:255',
            'enabled' => 'required|boolean'
        );
    }

    public function getWorkResults($parameters)
    {
        if (empty($parameters)) {
            $workResults = $this->filterWorkResults(WorkResult::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $workResults = WorkResult::with($withKeys)->where($whereClauses)->get();
            $workResults = $this->filterWorkResults($workResults, $withKeys);
        }

        return $workResults;
    }

    public function createWorkResult($request)
    {
        $this->validate($request->all());

        $workResult = new WorkResult();

        $workResult->description = $request->input("description");
        $workResult->enabled = $request->input("enabled");
        $workResult->save();

        return $this->filterWorkResults(array($workResult));
    }

    public function updateWorkResult($request, $id)
    {
        $this->validate($request->all());

        $workResult = WorkResult::findOrFail($id);
        $workResult->description = $request->input("description");
        $workResult->enabled = $request->input("enabled");

        $workResult->save();

        return $this->filterWorkResults(array($workResult));
    }

    public function deleteWorkResult($id)
    {
        $workResult = WorkResult::findOrFail($id);
        $workResult->delete();
    }

    private function filterWorkResults($workResults)
    {
        $data = array();

        foreach ($workResults as $workResult) {
            $item = array(
                'id' => $workResult->id,
                'description' => $workResult->description,
                'enabled' => $workResult->enabled,
                'href' => route('work_results.show', ['id' => $workResult->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}