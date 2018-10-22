<?php
namespace App\Services\v1;

use App\Models\Mobility;

class MobilityService extends BaseService
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
            'index',
            'enabled'
        );
        $this->rules = array(
            'description' => 'required|max:255',
            'index' => 'required|integer',
            'enabled' => 'required|boolean'
        );
    }

    public function getMobilities($parameters)
    {
        if (empty($parameters)) {
            $mobilities = $this->filterMobilities(Mobility::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $mobilities = Mobility::with($withKeys)->where($whereClauses)->orderBy('index')->get();
            $mobilities = $this->filterMobilities($mobilities, $withKeys);
        }

        return $mobilities;
    }

    public function createMobility($request)
    {
        $this->validate($request->all());

        $mobility = new Mobility();

        $mobility->description = $request->input("description");
        $mobility->enabled = $request->input("enabled");
        $mobility->index = $request->input("index");
        $mobility->save();

        return $this->filterMobilities(array($mobility));
    }

    public function updateMobility($request, $id)
    {
        $this->validate($request->all());

        $mobility = Mobility::findOrFail($id);
        $mobility->description = $request->input("description");
        $mobility->enabled = $request->input("enabled");
        $mobility->index = $request->input("index");

        $mobility->save();

        return $this->filterMobilities(array($mobility));
    }

    public function deleteMobility($id)
    {
        $mobility = Mobility::findOrFail($id);
        $mobility->delete();
    }

    private function filterMobilities($mobilities)
    {
        $data = array();

        foreach ($mobilities as $mobility) {
            $item = array(
                'id' => $mobility->id,
                'description' => $mobility->description,
                'index' => $mobility->index,
                'enabled' => $mobility->enabled,
                'href' => route('mobilities.show', ['id' => $mobility->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}