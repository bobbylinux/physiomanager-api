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
            'therapy_id',
            'physiotherapist_id',
            'price',
            'units',
            'note',
            'date',
            'plan_id'
        );
        $this->rules = array(
            'therapy_id' => 'required',
            'physiotherapist_id' => 'required',
            'price' => 'required|numeric',
            'units' => 'required|numeric',
            'plan_id' => 'required|integer'
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

        $session->date = $request->input("date");
        $session->therapy_id = $request->input("therapy_id");
        $session->physiotherapist_id = $request->input("physiotherapist_id");
        $session->price = $request->input("price");
        $session->units = $request->input("units");
        $session->note = $request->input("note");
        $session->plan_id = $request->input("plan_id");
        $session->save();

        return $this->filterSessions(array($session));
    }

    public function updateSession($request, $id)
    {
        $this->validate($request->all());

        $session = Session::findOrFail($id);
        $session->date = $request->input("date");
        $session->therapy_id = $request->input("therapy_id");
        $session->physiotherapist_id = $request->input("physiotherapist_id");
        $session->price = $request->input("price");
        $session->units = $request->input("units");
        $session->note = $request->input("note");
        $session->plan_id = $request->input("plan_id");

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
                'therapy_id' => $session->therapy_id,
                'physiotherapist_id' => $session->physiotherapist_id,
                'date' => $session->date,
                'units' => $session->units,
                'price' => $session->price,
                'note' => $session->note,
                'href' => route('sessions.show', ['id' => $session->id])
            );
            $data[] = $item;
        }

        return $data;
    }
}