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


    public function getAttendance(Request $request){
        $req = $request->all();


        $baseRequest = [];

        if (isset($req['student_id'])){
            $baseRequest[] = ['student_id', $req['student_id']];
        }
        if (isset($req['class_type_id'])){
            $baseRequest[] = ['class_type_id', $req['class_type_id']];
        }
        if (isset($req['academic_session_id'])){
            $baseRequest[] = ['academic_session_id', $req['academic_session_id']];
        }if (isset($req['term_id'])){
            $baseRequest[] = ['term_id', $req['term_id']];
        }

        try {
            /*get total attendance, missing Attendance, and attendance by term*/
            $totalTermAttendance  = Attendance::where($baseRequest)->count();
            $missingAttendance  = Attendance::where($baseRequest)->where('attendance',0)->count();
            $attended  = Attendance::where($baseRequest)->where('attendance',1)->count();

            return response()->json([
                'attended'=>$attended,
                'missingAttendance' => $missingAttendance,
                'totalAttendance' => $totalTermAttendance
            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'Error' => $exception->getMessage()
            ],500);
        }


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
