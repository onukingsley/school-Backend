<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResultsCollection;
use App\Http\Resources\ResultsResource;
use App\Models\Results;
use App\Services\v1\ResultQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ResultQuery();

        $query = $filter->transform($request);

        $result = Results::where($query);

        $include = [];

        if ($request->has('student')){
            $include[] = 'student';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('classType')){
            $include[] = 'classType';
        }
        if ($request->has('term')){
            $include[] = 'term';
        }
        if ($request->has('grade')){
            $include[] = 'grade';
        }
        if ($request->has('academicSession')){
            $include[] = 'academicSession';
        }

        $result = $result->with($include);

        return new ResultsCollection($result->latest()->paginate()->appends($request->query()));


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
        $results = Results::create($formRequest);

        return response(new ResultsResource($results),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Results $results, Request $request)
    {
        $include = [];

        if ($request->has('student')){
            $include[] = 'student';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('classType')){
            $include[] = 'classType';
        }
        if ($request->has('term')){
            $include[] = 'term';
        }
        if ($request->has('grade')){
            $include[] = 'grade';
        }
        if ($request->has('academicSession')){
            $include[] = 'academicSession';
        }


        $results = $results->with($include);
        return response()->json(new ResultsResource($results),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Results $results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Results $results)
    {
        $results = $results->update($request->all());
        return response()->json($results,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Results $results)
    {

        $results->delete();
        return response()->json(['message'=>"Result Record was deleted successfully"],200);
    }
}
