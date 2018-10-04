<?php

namespace App\Http\Controllers\v1;

use App\Services\v1\TherapyService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TherapyController extends Controller
{
    /**
     * Private actributes
     */
    private $therapies;

    /**
     * Construct the class and Dependency Injection.
     *
     */
    public function __construct(TherapyService $therapies)
    {
        $this->therapies = $therapies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();

        $data = $this->therapies->getTherapies($parameters);

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
            $therapy = $this->therapies->createTherapy($request);
            return response()->json(['data' => $therapy], 201);
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

        $data = $this->therapies->getTherapies($parameters);

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
            $therapy = $this->therapies->updateTherapy($request, $id);
            return response()->json(['data' => $therapy], 200);
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
            $this->therapies->deleteTherapy($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            return response()->json(array('message' => $exception->getMessage(), ''),500);
        }
    }
}
