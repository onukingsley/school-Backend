<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectCollection;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\Services\v1\SubjectQuery;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new SubjectQuery();

        $query = $filter->transform($request);

        $subject = Subject::where($query);

        $include = [];

        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('Assignment')){
            $include[] = 'Assignment';
        }
        if ($request->has('Exam')){
            $include[] = 'Exam';
        }

        $subject = $subject->with($include);

        return new SubjectCollection($subject->latest()->paginate()->appends($request->query()));


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
        $subject = Subject::create($formRequest);

        return response(new SubjectResource($subject),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Request $request)
    {
        $include = [];
        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }

        $subject = $subject->loadMissing($include);
        return response()->json($subject,200);
        //return response()->json(new SubjectResource($subject),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $subject = $subject->update($request->all());
        return response()->json($subject,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $title = $subject->title;
        $subject->delete();
        return response()->json(['message'=>"Assignment: {$title} deleted successfully"],200);
    }
}
