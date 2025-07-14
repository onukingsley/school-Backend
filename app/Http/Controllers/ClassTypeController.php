<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassTypeCollection;
use App\Http\Resources\ClassTypeResource;
use App\Models\Assignment;
use App\Models\Class_type;
use App\Services\v1\AssignmentQuery;
use App\Services\v1\ClassTypeQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ClassTypeQuery();

        $query = $filter->transform($request);

        $classType = Class_type::where($query);

        $include = [];

        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Exam')){
            $include[] = 'Exam';
        }
        if ($request->has('Assignment')){
            $include[] = 'Assignment';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('Student')){
            $include[] = 'Student';
        }


        $classType = $classType->with($include);

        return new ClassTypeCollection($classType->latest()->paginate()->appends($request->query()));


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
        $classType = Class_type::create($formRequest);

        return response(new ClassTypeResource($classType),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Class_type $class_type, Request $request)
    {
        $include = [];
        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Exam')){
            $include[] = 'Exam';
        }
        if ($request->has('Assignment')){
            $include[] = 'Assignment';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('Student')){
            $include[] = 'Student';
        }

        $class_type = $class_type->with($include);
        return response()->json(new ClassTypeResource($class_type),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Class_type $class_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Class_type $class_type)
    {
        $class_type = $class_type->update($request->all());
        return response()->json($class_type,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Class_type $class_type)
    {
        $className = $class_type->class_name;
        $class_type->delete();
        return response()->json(['message'=>"ClassType: {$className} deleted successfully"],200);
    }
}
