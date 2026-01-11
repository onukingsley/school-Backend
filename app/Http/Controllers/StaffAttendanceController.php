<?php

namespace App\Http\Controllers;


use App\Models\Staff;
use App\Services\v1\StaffAttendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new StaffAttendance();

        $query = $filter->transform($request);

        $staffAttendance = StaffAttendance::where($query);


        return response()->json($staffAttendance->latest()->paginate()->appends($request->query()),200);

    }

    public function getAttendance(Request $request){

        $baseQuery = [];
        if (isset($request['staff_id'])){
            $baseQuery[] = ['staff_id',$request['staff_id']];
        }
        if (isset($request['academic_session_id'])){
            $baseQuery[] = ['academic_session_id',$request['academic_session_id']];
        }
        if (isset($request['term_id'])){
            $baseQuery[] = ['term_id',$request['term_id']];
        }

        $totalAttendance = StaffAttendance::where($baseQuery)->count();
        $attended = StaffAttendance::where($baseQuery)->where('attendance',0)->count();
        $missingAttendance = $totalAttendance - $attended;
        return response()->json([
            'attended'=>$attended,
            'missingAttendance' => $missingAttendance,
            'totalAttendance' => $totalAttendance
        ],200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffAttendance $staffAttendance)
    {
        //
    }
}
