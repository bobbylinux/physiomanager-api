<?php

namespace App\Services\v1;

use App\Models\Therapy;

class TherapyService extends BaseService
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

    public function getTherapies($parameters)
    {
        if (empty($parameters)) {
            $therapies = $this->filterTherapies(Therapy::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $therapies = Therapy::with($withKeys)->where($whereClauses)->get();
            $therapies = $this->filterTherapies($therapies, $withKeys);
        }

        return $therapies;
    }

    public function createTherapy($request)
    {
        $this->validate($request->all());

        $therapy = new Therapy();

        $therapy->description = $request->input("description");
        $therapy->enabled = $request->input("enabled");
        $therapy->price = $request->input("price");
        $therapy->save();

        return $this->filterTherapies(array($therapy));
    }

    public function updateTherapy($request, $id)
    {
        $this->validate($request->all());

        $therapy = Therapy::findOrFail($id);
        $therapy->description = $request->input("description");
        $therapy->enabled = $request->input("enabled");
        $therapy->price = $request->input("price");

        $therapy->save();

        return $this->filterTherapies(array($therapy));
    }

    public function deleteTherapy($id)
    {
        $therapy = Therapy::findOrFail($id);
        $therapy->delete();
    }

    private function filterTherapies($therapies)
    {
        $data = array();

        foreach ($therapies as $therapy) {
            $item = array(
                'id' => $therapy->id,
                'description' => $therapy->description,
                'enabled' => $therapy->enabled,
                'price' => $therapy->price,
                'href' => route('therapies.show', ['id' => $therapy->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}