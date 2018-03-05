<?php
namespace App\Services\v1;

use App\Models\Session;

class SessionService extends BaseService
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

    public function getSessions($parameters)
    {
        if (empty($parameters)) {
            $sessions = $this->filterSessions(Session::all());
        } else {
            $withKeys = $this->getWithKeys($parameters);
            $whereClauses = $this->getWhereClause($parameters);
            $sessions = Session::with($withKeys)->where($whereClauses)->get();
            $sessions = $this->filterSessions($sessions, $withKeys);
        }

        return $sessions;
    }

    public function createSession($request)
    {
        $this->validate($request->all());

        $session = new Session();

        $session->description = $request->input("description");
        $session->enabled = $request->input("enabled");
        $session->price = $request->input("price");
        $session->save();

        return $this->filterSessions(array($session));
    }

    public function updateSession($request, $id)
    {
        $this->validate($request->all());

        $session = Session::findOrFail($id);
        $session->description = $request->input("description");
        $session->enabled = $request->input("enabled");
        $session->price = $request->input("price");

        $session->save();

        return $this->filterSessions(array($session));
    }

    public function deleteSession($id)
    {
        $session = Session::findOrFail($id);
        $session->delete();
    }

    private function filterSessions($sessions)
    {
        $data = array();

        foreach ($sessions as $session) {
            $item = array(
                'id' => $session->id,
                'description' => $session->description,
                'enabled' => $session->enabled,
                'price' => $session->price,
                'href' => route('sessions.show', ['id' => $session->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}