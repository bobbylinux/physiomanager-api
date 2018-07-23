<?php

namespace App\Http\Controllers\v1;

use App\Services\v1\SessionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    /**
     * Private actributes
     */
    private $sessions;

    /**
     * Construct the class and Dependency Injection.
     *
     */
    public function __construct(SessionService $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();

        $data = $this->sessions->getSessions($parameters);

        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $session = $this->sessions->createSession($request);
            return response()->json(['data' => $session], 201);
        } catch (Exception $exception) {
            return response()->json(array('message' => $exception->getMessage(), ''),500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parameters = request()->input();
        $parameters['id'] = $id;

        $data = $this->sessions->getSessions($parameters);

        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $session = $this->sessions->updateSession($request, $id);
            return response()->json(['data' => $session], 200);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            return response()->json(array('message' => $exception->getMessage(), ''),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->sessions->deleteSession($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            return response()->json(array('message' => $exception->getMessage(), ''),500);
        }
    }
}
