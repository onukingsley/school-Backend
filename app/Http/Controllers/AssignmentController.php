<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssignmentCollection;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Services\v1\AssignmentQuery;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AssignmentQuery();

        $query = $filter->transform($request);

        $assignment = Assignment::where($query);

        $include = [];

        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }

        $assignment = $assignment->with($include);

        return new AssignmentCollection($assignment->latest()->paginate()->appends($request->query()));


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
        $assignment = Assignment::create($formRequest);

        return response(new AssignmentResource($assignment),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Request $request)
    {
        $include = [];
        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }

        $assignment = $assignment->with($include);
        return response()->json(new AssignmentResource($assignment),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $assignment = $assignment->update($request->all());
        return response()->json($assignment,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $title = $assignment->title;
        $assignment->delete();
        return response()->json(['message'=>"Assignment: {$title} deleted successfully"],200);
    }
}
