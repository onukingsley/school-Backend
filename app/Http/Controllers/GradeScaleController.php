<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradeScaleCollection;
use App\Http\Resources\GradeScaleResource;
use App\Models\Assignment;
use App\Models\GradeScale;
use App\Services\v1\GradeScaleQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new GradeScaleQuery();
        $query = $filter->transform($request);



        $include = [];
        if ($request->has('result')){
            $include[] = 'Result';
        }

        $gradeScale = GradeScale::where($query)->with($include)->get();

        return response(new GradeScaleCollection($gradeScale));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formRequest = $request->all();
        $gradeScale = GradeScale::create($formRequest);

        return response(new GradeScaleResource($gradeScale),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeScale $gradeScale, Request $request)
    {
        $include = [];
        if ($request->has('result')){
            $include[] = 'Result';
        }

        $gradeScale = $gradeScale->with($include);
        return response()->json(new GradeScaleResource($gradeScale),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeScale $gradeScale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeScale $gradeScale)
    {
        $gradeScale = $gradeScale->update($request->all());
        return response()->json($gradeScale,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeScale $gradeScale)
    {
        $grade = $gradeScale->title;
        $gradeScale->delete();
        return response()->json(['message'=>"Assignment: {$grade} deleted successfully"],200);
    }
}
