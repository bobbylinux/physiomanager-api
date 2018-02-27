<?php

namespace App\Http\Controllers\v1;

use App\Services\v1\PhysiotherapistService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhysiotherapistController extends Controller
{
    /**
     * Private actributes
     */
    private $physiotherapist;

    /**
     * Construct the class and Dependency Injection.
     *
     */
    public function __construct(PhysiotherapistService $physiotherapist)
    {
        $this->physiotherapists = $physiotherapist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();

        $data = $this->physiotherapists->getPhysiotherapists($parameters);

        return response()->json($data);
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
            $physiotherapist = $this->physiotherapists->createPhysiotherapist($request);
            return response()->json($physiotherapist, 201);
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

        $data = $this->physiotherapists->getPhysiotherapists($parameters);

        return response()->json($data);
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
            $physiotherapist = $this->physiotherapists->updatePhysiotherapist($request, $id);
            return response()->json($physiotherapist, 200);
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
            $this->physiotherapists->deletePhysiotherapist($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            return response()->json(array('message' => $exception->getMessage(), ''),500);
        }
    }
}
