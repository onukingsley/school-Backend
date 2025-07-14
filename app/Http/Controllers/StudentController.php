<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\v1\StudentQuery;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new StudentQuery();

        $query = $filter->transform($request);

        $student = Student::where($query);

        $include = [];

        if ($request->has('User')){
            $include[] = 'User';
        }
        if ($request->has('Guardian')){
            $include[] = 'Guardian';
        }
        if ($request->has('ClassType')){
            $include[] = 'ClassType';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('Schoolfees')){
            $include[] = 'Schoolfees';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('ResultCheck')){
            $include[] = 'ResultCheck';
        }

        $student = $student->with($include);

        return new StudentCollection($student->latest()->paginate()->appends($request->query()));


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
        $student = Student::create($formRequest);

        return response(new StudentResource($student),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student, Request $request)
    {
        $include = [];
        if ($request->has('User')){
            $include[] = 'User';
        }
        if ($request->has('Guardian')){
            $include[] = 'Guardian';
        }
        if ($request->has('ClassType')){
            $include[] = 'ClassType';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('Schoolfees')){
            $include[] = 'Schoolfees';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('ResultCheck')){
            $include[] = 'ResultCheck';
        }

        $assignment = $student->with($include);
        return response()->json(new StudentResource($student),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student = $student->update($request->all());
        return response()->json($student,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $id = $student->id;
        $student->delete();
        return response()->json(['message'=>"Student with ID: {$id} was deleted successfully"],200);
    }
}
