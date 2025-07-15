<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResultsCollection;
use App\Http\Resources\ResultsResource;
use App\Models\Assignment;
use App\Models\Results;
use App\Models\Student;
use App\Services\v1\ResultQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Clock\get;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ResultQuery();

        $query = $filter->transform($request);

        $result = Results::where($query);

        $include = [];

        if ($request->has('student')){
            $include[] = 'student';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('classType')){
            $include[] = 'classType';
        }
        if ($request->has('term')){
            $include[] = 'term';
        }
        if ($request->has('grade')){
            $include[] = 'grade';
        }
        if ($request->has('academicSession')){
            $include[] = 'academicSession';
        }

        $result = $result->with($include);

        return new ResultsCollection($result->latest()->paginate()->appends($request->query()));


    }




    public function getPendingAssignment(Request $request){

        $req = $request->all();

        $result = Results::with(['student:id,user_id','student.user:id,name,reg_no,profile_img'])
            ->select('term_id', 'academic_session_id', 'student_id', 'subject_id', 'class_type_id', 'assignment1', 'assignment2')
            ->where([['student_id',$req['student_id']],
            ['term_id',$req['term_id']],
            ['academic_session_id',$req['academic_session_id']],

            ])->where(function ($q){
                $q->orWhere('assignment1','')
                ->orWhere('assignment2','')
                    ->orWhereNull('assignment1')
                ->orWhereNull('assignment2');
        })

            ->get();


        /*get pending assignment*/

        $assignment = Assignment::where(function ($q) use ($result){

            foreach ($result as $res){

                if ($res->assignment1==''||$res->assignment1==null){
                    $q->orwhere(function ($subQuery) use ($res){
                        $subQuery->where([
                            ['subject_id',$res->subject_id],
                            ['class_type_id',$res->class_type_id],
                            ['term_id',$res->term_id],
                            ['academic_session_id',$res->academic_session_id],
                            ['assignment_status','assignment1'],
                        ]);
                    });

                }
                if ($res->assignment2==''||$res->assignment2==null){
                    $q->orwhere(function ($subQuery) use ($res){
                        $subQuery->where([
                            ['subject_id',$res->subject_id],
                            ['class_type_id',$res->class_type_id],
                            ['term',$res->term_id],
                            ['academic_session_id',$res->academic_session_id],
                            ['assignment_status','assignment2'],
                        ]);
                    });

                }

            }
        })->get();


        return response()->json([
           'missing assignment' => $result,
            'pendingAssignment' => $assignment
        ],200);
    }


    public function getStudentOrResult(Request $request){

        $res = $request->all();
        $result = Results::where('class_type_id',$res['class_type_id'])
            ->where('subject_id',$res['subject_id'])
            ->where('term_id',$res['term_id'])
            ->where('academic_session_id',$res['academic_session_id'])
            ->with(['student:id,user_id','student.user:id,name,reg_no,profile_img'])
            ->get();

        if ($result->isNotEmpty()){
            return response()->json([
                'type' => 'result',
                'data' => $result
            ],200);
        }

        $student  = Student::where('class_type_id',$res['class_type_id'])
            ->with('user:id,name,reg_no')
            ->get();

        return response()->json([
            'type' => 'student',
            'data' => $student
        ],200);


    }


    /*
     * This function update or insert result records into the database;
     * */
    public function upsertToDB(Request $request){
        $req = $request->all();

        try {
           Results::upsert($req,['student_id','subject_id','class_type_id','term_id','academic_session_id'],['test1','test2','assignment1','assignment2','total','exam']);
           return response()->json(['message'=>'Records Updated Successfully'],200);
        }catch (\Exception $exception){
            return response()->json(['error'=>$exception->getMessage()],500);
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
        $results = Results::create($formRequest);

        return response(new ResultsResource($results),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Results $results, Request $request)
    {
        $include = [];

        if ($request->has('student')){
            $include[] = 'student';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('classType')){
            $include[] = 'classType';
        }
        if ($request->has('term')){
            $include[] = 'term';
        }
        if ($request->has('grade')){
            $include[] = 'grade';
        }
        if ($request->has('academicSession')){
            $include[] = 'academicSession';
        }


        $results = $results->with($include);
        return response()->json(new ResultsResource($results),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Results $results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Results $results)
    {
        $results = $results->update($request->all());
        return response()->json($results,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Results $results)
    {

        $results->delete();
        return response()->json(['message'=>"Result Record was deleted successfully"],200);
    }
}
