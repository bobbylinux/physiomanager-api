<?php
namespace App\Services\v1;

use App\Models\Pain;

class PainService extends BaseService
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

    public function getPains($parameters)
    {
        if (empty($parameters)) {
            $pains = $this->filterPains(Pain::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $pains = Pain::with($withKeys)->where($whereClauses)->get();
            $pains = $this->filterPains($pains, $withKeys);
        }

        return $pains;
    }

    public function createPain($request)
    {
        $this->validate($request->all());

        $pain = new Pain();

        $pain->description = $request->input("description");
        $pain->enabled = $request->input("enabled");
        $pain->save();

        return $this->filterPains(array($pain));
    }

    public function updatePain($request, $id)
    {
        $this->validate($request->all());

        $pain = Pain::findOrFail($id);
        $pain->description = $request->input("description");
        $pain->enabled = $request->input("enabled");

        $pain->save();

        return $this->filterPains(array($pain));
    }

    public function deletePain($id)
    {
        $pain = Pain::findOrFail($id);
        $pain->delete();
    }

    private function filterPains($pains)
    {
        $data = array();

        foreach ($pains as $pain) {
            $item = array(
                'id' => $pain->id,
                'description' => $pain->description,
                'enabled' => $pain->enabled,
                'href' => route('pains.show', ['id' => $pain->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}