<?php

namespace App\Services\v1;

use App\Models\Physiotherapist;

class PhysiotherapistService extends BaseService
{
    /**
     * Construct the class.
     *
     */
    public function __construct()
    {
        $this->clauseProperties = array(
            'id',
            'last_name',
            'first_name',
            'enabled'
        );
        $this->rules = array(
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'enabled' => 'required|boolean'
        );
    }

    public function getPhysiotherapists($parameters)
    {
        if (empty($parameters)) {
            $physiotherapists = $this->filterPhysiotherapists(Physiotherapist::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $physiotherapists = Physiotherapist::with($withKeys)->where($whereClauses)->orderBy('last_name')->get();
            $physiotherapists = $this->filterPhysiotherapists($physiotherapists, $withKeys);
        }

        return $physiotherapists;
    }

    public function createPhysiotherapist($request)
    {
        $this->validate($request->all());

        $physiotherapist = new Physiotherapist();

        $physiotherapist->first_name = $request->input("first_name");
        $physiotherapist->last_name = $request->input("last_name");
        $physiotherapist->enabled = $request->input("enabled");
        $physiotherapist->save();

        return $this->filterPhysiotherapists(array($physiotherapist));
    }

    public function updatePhysiotherapist($request, $id)
    {
        $this->validate($request->all());

        $physiotherapist = Physiotherapist::findOrFail($id);
        $physiotherapist->first_name = $request->input("first_name");
        $physiotherapist->last_name = $request->input("last_name");
        $physiotherapist->enabled = $request->input("enabled");

        $physiotherapist->save();

        return $this->filterPhysiotherapists(array($physiotherapist));
    }

    public function deletePhysiotherapist($id)
    {
        $physiotherapist = Physiotherapist::findOrFail($id);
        $physiotherapist->delete();
    }

    private function filterPhysiotherapists($physiotherapists)
    {
        $data = array();

        foreach ($physiotherapists as $physiotherapist) {
            $item = array(
                'id' => $physiotherapist->id,
                'last_name' => $physiotherapist->last_name,
                'first_name' => $physiotherapist->first_name,
                'enabled' => $physiotherapist->enabled,
                'href' => route('physiotherapists.show', ['id' => $physiotherapist->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}