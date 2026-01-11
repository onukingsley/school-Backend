<?php

namespace App\Http\Controllers;

use App\Http\Resources\AcademicSessionCollection;
use App\Http\Resources\AcademicSessionResource;
use App\Models\Session;
use App\Models\Term;
use App\Services\v1\SessionQuery;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new SessionQuery();

        $query = $filter->transform($request);

        $academicSession = Session::where($query);

        $include = [];

        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('SchoolFees')){
            $include[] = 'SchoolFees';
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
        if ($request->has('ExamTable')){
            $include[] = 'ExamTable';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }

        $academicSession = $academicSession->with($include);

        return ($academicSession->latest()->paginate(10)->appends($request->query()));


    }


    public function getCurrentTermAndSession(){
        try {
            $term = Term::select('id','name')->where('current_term','1')->first();

            $session = Session::select('id','year')->latest()->first();

            return response()->json(['term'=>$term, 'academic_session'=>$session],200);
        }catch (\Exception $exception){
            return response()->json(['error'=>$exception->getMessage()],501);
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
        $academicSession = Session::create($formRequest);

        return response(new AcademicSessionResource($academicSession),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session, Request $request)
    {
        $include = [];
        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('SchoolFees')){
            $include[] = 'SchoolFees';
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
        if ($request->has('ExamTable')){
            $include[] = 'ExamTable';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }

        $session = $session->with($include);
        return response()->json(new AcademicSessionResource($session),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        $session = $session->update($request->all());
        return response()->json($session,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        $title = $session->year;
        $session->delete();
        return response()->json(['message'=>"Academic Session with year: {$title} deleted successfully"],200);
    }
}
