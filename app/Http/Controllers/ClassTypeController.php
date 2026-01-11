<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassTypeCollection;
use App\Http\Resources\ClassTypeResource;
use App\Models\Assignment;

use App\Models\ClassType;
use App\Models\Subject;
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

        $classType = ClassType::where($query);

        $include = [];

        if ($request['Staff']){
            $include[] = 'Staff';
        }
        if ($request['Exam']){
            $include[] = 'Exam';
        }
        if ($request['Assignment']){
            $include[] = 'Assignment';
        }
        if ($request['TimeTable']){
            $include[] = 'TimeTable';
        }
        if ($request['Result']){
            $include[] = 'Result';
        }
        if ($request['Attendance']){
            $include[] = 'Attendance';
        }
        if ($request['Student']){
            $include[] = 'Student';
        }


        $classType = $classType->with($include);

        return new ClassTypeCollection($classType->latest()->paginate()->appends($request->query()));


    }

    public function getSubject(Request $request){
        $req = $request->all();

        $class_type = ClassType::where('id', $req['id'])->get();



        $subjectList = [];


        foreach ($class_type[0]['subject'] as $item){
            //$subject = Subject::where('id',$item)->with(['Staff:id,user_id','Staff.user:id,name,reg_no,profile_image'])->get();
            $subject = Subject::where('title',$item)->with(['Staff:id,user_id','Staff.user:id,name,reg_no,profile_image'])->get();

            if ($subject){
                $subjectList[] = $subject;
            }
        }

        if (count($subjectList)!==0){
            return response()->json(['subject'=>$subjectList]);
        }
        return response()->json(['subject'=>"No Subject Record Found"]);


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
        $classType = ClassType::create($formRequest);

        return response(new ClassTypeResource($classType),200);
    }
    public function getClassType(Request $request){
        $req = $request->all();

        $classType = ClassType::where('id',$req['id'])->get();
        $include = [];
        if ($request['Staff']){
            $include[] = 'Staff';
        }
        if ($request['Exam']){
            $include[] = 'Exam';
        }
        if ($request['Assignment']){
            $include[] = 'Assignment';
        }
        if ($request['TimeTable']){
            $include[] = 'TimeTable';
        }
        if ($request['Result']){
            $include[] = 'Result';
        }
        if ($request['Attendance']){
            $include[] = 'Attendance';
        }
        if ($request['Student']){
            $include[] = 'Student';
        }

        $classType = $classType->loadMissing($include);
        return response()->json($classType,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassType $classtype, Request $request)
    {
        try {
            $include = [];
            if ($request['Staff']){
                $include[] = 'Staff';
            }
            if ($request['Exam']){
                $include[] = 'Exam';
            }
            if ($request['Assignment']){
                $include[] = 'Assignment';
            }
            if ($request['TimeTable']){
                $include[] = 'TimeTable';
            }
            if ($request['Result']){
                $include[] = 'Result';
            }
            if ($request['Attendance']){
                $include[] = 'Attendance';
            }
            if ($request['Student']){
                $include[] = 'Student';
            }

            $classtype = $classtype->loadMissing($include);
            return response()->json($classtype,200);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassType $class_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassType $class_type)
    {
        $class_type = $class_type->update($request->all());
        return response()->json($class_type,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassType $class_type)
    {
        $className = $class_type->class_name;
        $class_type->delete();
        return response()->json(['message'=>"ClassType: {$className} deleted successfully"],200);
    }
}
