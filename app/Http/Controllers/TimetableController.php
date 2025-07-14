<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeTableCollection;
use App\Http\Resources\TimeTableResource;
use App\Models\timetable;
use App\Services\v1\TimeTableQuery;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new TimeTableQuery();

        $query = $filter->transform($request);

        $timetable = timetable::where($query);

        $include = [];

        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }

        $timetable = $timetable->with($include);

        return new TimeTableCollection($timetable->latest()->paginate()->appends($request->query()));


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
        $timetable = timetable::create($formRequest);

        return response(new TimeTableResource($timetable),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(timetable $timetable, Request $request)
    {
        $include = [];
        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }


        $timetable = $timetable->with($include);
        return response()->json(new TimeTableResource($timetable),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, timetable $timetable)
    {
        $timetable = $timetable->update($request->all());
        return response()->json($timetable,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(timetable $timetable)
    {
        $title = $timetable->id;
        $timetable->delete();
        return response()->json(['message'=>"TimeTable with ID: {$title} waas deleted successfully"],200);
    }
}
