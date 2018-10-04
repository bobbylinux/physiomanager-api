<?php

namespace App\Http\Controllers\v1;

use App\Services\v1\MobilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MobilityController extends Controller
{
    /**
     * Private actributes
     */
    private $mobilities;

    /**
     * Construct the class and Dependency Injection.
     *
     */
    public function __construct(MobilityService $mobilities)
    {
        $this->mobilities = $mobilities;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();

        $data = $this->mobilities->getMobilities($parameters);

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
            $mobility = $this->mobilities->createMobility($request);
            return response()->json(['data' => $mobility], 201);
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

        $data = $this->mobilities->getMobilities($parameters);

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
            $mobility = $this->mobilities->updateMobility($request, $id);
            return response()->json(['data' => $mobility], 200);
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
            $this->mobilities->deleteMobility($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            return response()->json(array('message' => $exception->getMessage(), ''),500);
        }
    }
}
