<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceCollection;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Services\v1\AttendanceQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AttendanceQuery();

        $query = $filter->transform($request);

        $attendance = Attendance::where($query);

        $include = [];

        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('ClassType')){
            $include[] = 'ClassType';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }

        $attendance = $attendance->with($include);

        return new AttendanceCollection($attendance->latest()->paginate()->appends($request->query()));


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
        $attendance = Attendance::create($formRequest);

        return response(new AttendanceResource($attendance),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance,Request $request)
    {
        $include = [];

        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('ClassType')){
            $include[] = 'ClassType';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }

        $attendance = $attendance->with($include);
        return response()->json(new AttendanceResource($attendance),200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $attendance = $attendance->update($request->all());
        return response()->json($attendance,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {

        $attendance->delete();
        return response()->json(['message'=>"Attendance deleted successfully"],200);
    }
}
