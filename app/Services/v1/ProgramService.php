<?php
namespace App\Services\v1;

use App\Models\Program;

class ProgramService extends BaseService
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

    public function getPrograms($parameters)
    {
        if (empty($parameters)) {
            $programs = $this->filterPrograms(Program::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $programs = Program::with($withKeys)->where($whereClauses)->get();
            $programs = $this->filterPrograms($programs, $withKeys);
        }

        return $programs;
    }

    public function createProgram($request)
    {
        $this->validate($request->all());

        $program = new Program();

        $program->description = $request->input("description");
        $program->enabled = $request->input("enabled");
        $program->save();

        return $this->filterPrograms(array($program));
    }

    public function updateProgram($request, $id)
    {
        $this->validate($request->all());

        $program = Program::findOrFail($id);
        $program->description = $request->input("description");
        $program->enabled = $request->input("enabled");

        $program->save();

        return $this->filterPrograms(array($program));
    }

    public function deleteProgram($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();
    }

    private function filterPrograms($programs)
    {
        $data = array();

        foreach ($programs as $program) {
            $item = array(
                'id' => $program->id,
                'description' => $program->description,
                'enabled' => $program->enabled,
                'href' => route('programs.show', ['id' => $program->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}