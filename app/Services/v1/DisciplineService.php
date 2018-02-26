<?php

namespace App\Services\v1;

use App\Models\Discipline;

class DisciplineService extends BaseService
{
    /**
     * Construct the class and Dependency Injection.
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

    public function getDisciplines($parameters)
    {
        if (empty($parameters)) {
            $disciplines = $this->filterDisciplines(Discipline::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $disciplines = Discipline::with($withKeys)->where($whereClauses)->get();
            $disciplines = $this->filterDisciplines($disciplines, $withKeys);
        }

        return $disciplines;
    }

    public function createDiscipline($request)
    {
        $this->validate($request->all());

        $discipline = new Discipline();

        $discipline->description = $request->input("description");
        $discipline->enabled = $request->input("enabled");
        $discipline->save();

        return $this->filterDisciplines(array($discipline));
    }

    public function updateDiscipline($request, $id)
    {
        $this->validate($request->all());

        $discipline = Discipline::findOrFail($id);
        $discipline->description = $request->input("description");
        $discipline->enabled = $request->input("enabled");

        $discipline->save();

        return $this->filterDisciplines(array($discipline));
    }

    public function deleteDiscipline($id)
    {
        $discipline = Discipline::findOrFail($id);
        $discipline->delete();
    }

    private function filterDisciplines($disciplines)
    {
        $data = array();

        foreach ($disciplines as $discipline) {
            $item = array(
                'id' => $discipline->id,
                'description' => $discipline->description,
                'enabled' => $discipline->enabled,
                'href' => route('disciplines.show', ['id' => $discipline->id])
            );
            $data[] = $item;
        }

        return $data;
    }

    private function getWithKeys($parameters)
    {
        $withKeys = array();

        if (isset($parameters['include'])) {
            $includeParams = explode(",", $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParams);
            $withKeys = array_keys($includes);
        }

        return $withKeys;

    }
}