<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResultsCollection;
use App\Http\Resources\ResultsResource;
use App\Models\Assignment;
use App\Models\Results;
use App\Models\ResultsCheck;
use App\Models\Session;
use App\Models\Student;
use App\Models\Term;
use App\Services\v1\ResultQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Carbon\int;
use function PHPUnit\Framework\isEmpty;
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

        try{
            $req = $request->all();

            $result = Results::with(['student:id,user_id','student.user:id,name,reg_no,profile_image'])
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


            $assignment = null;

            /*get pending assignment*/
            if ($result->isNotEmpty()){
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
                                    ['term_id',$res->term_id],
                                    ['academic_session_id',$res->academic_session_id],
                                    ['assignment_status','assignment2'],
                                ]);
                            });

                        }

                    }
                })->with('subject')->get();
            }




            return response()->json([
                'missing assignment' => $result,
                'pendingAssignment' => $assignment,
                'countOfPendingAssignment' =>$assignment ? $assignment->count(): 0
            ],200);
        }catch(\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }

    }

    public function getTestAndAssignmentData(Request $request){

        /*Note: This request requires student_id, term_id and academic_session_id*/

        $req = $request->all();

        $results = Results::where([
            ['student_id',$req['student_id']],
            ['term_id',$req['term_id']],
            ['academic_session_id',$req['academic_session_id']]
        ])->with('subject')->get();

        $assignment = [];
        $assignmentLabel = [];
        $assignment1 = [];
        $assignment2 = [];

        $test = [];
        $Label = [];
        $test1 = [];
        $test2 = [];

        foreach ($results as $result){
            $Label = [...$Label,$result->subject->title];
            $test1 = [...$test1,$result->test1];
            $test2 = [...$test2,$result->test2];

            $assignment1 = [...$assignment1,$result->assignment1];
            $assignment2 = [...$assignment2,$result->assignment2];

            $test = [
                'label_type' => 'test',
              'label' => $Label,

              'inputData' => [
                  ['data'=>$test1, 'labelType'=>'test1']
              ,
                  ['data'=>$test2, 'labelType'=>'test2']

              ]
            ];
            $assignment = [
                'label_type' => 'assignment',
                'label' => $Label,

                'inputData' =>[
                    ['data'=>$assignment1, 'labelType'=>'assignment1']

                    ,
                    ['data'=>$assignment2, 'labelType'=>'assignment2']

                ]

            ];
        }


        return response()->json(['test'=>$test,'assignment'=>$assignment],200);

    }

    public function getStudentResult(Request $request){

        /*request parameters: student_id, term_id, academic_session_id, pin*/

        $req = $request->all();
        //return response($req);
        $resultPin = ResultsCheck::where('token' , $req['pin'])->first();

        if (!$resultPin ){
            return response()->json(['error' => 'Pin is invalid '],501);
        }
        if ($resultPin->number_of_attempts >= 5){
            if ($req['studentId'] == $resultPin->student_id){
                return response()->json(['error' => 'Max Pin attempt used by you'],501);
            }
            return response()->json(['error' => 'Pin has exceeded number of Checks! '],501);
        }
        $result = Results::where([
            ['student_id',$req['studentId']],
            ['term_id',$req['termId']],
            ['academic_session_id',$req['academicSessionId']]
        ])->with(['subject','gradeScale'])->get();




        if(count($result)==0){
            return response()->json(['message' => 'No Record Found'],200);
        }else{
            $new_attempt = (int)$resultPin->number_of_attempts + 1;
            $newResultPin = $resultPin->update([
                'number_of_attempts'=> $new_attempt,
                'student_id'=> $req['studentId']
            ]);

            return response()->json(['result' => $result, 'resultPin'=>$newResultPin],200);
        }


    }


    public function getComparisonData(Request $request){
        $req = $request->all();

        $previousResult = [];
        $antiPreviousResult = [];
        $term = ['first','second','third'];
        $revisedPreviousResult = [];
        $antiRevisedPreviousResult = [];
        $totalArray = [];
        $similarArrayTotalScore = [];
        $label = [];
        $antiSimilarArrayTotalScore = [];

        $currentAcademicSession = Session::orderBy('id','desc')->first();
        $currentTerm = Term::where('current_term','1')->first();

        if($currentTerm->id == 1){
                $previousTerm_id = 3;
                $antiPreviousTerm_id = 2;
                $previousSession = $currentAcademicSession->id - 1;

                $previousResult = Results::where([
                    ['student_id', $req['student_id']],
                    ['academic_session_id', $previousSession],
                    ['term_id', $previousTerm_id],
                ])->orderBy('subject_id','asc')->with('subject')->get();


            $antiPreviousResult = Results::where([
                ['student_id', $req['student_id']],
                ['academic_session_id', $previousSession],
                ['term_id', $antiPreviousTerm_id],
            ])->orderBy('subject_id','asc')->with('subject')->get();


            foreach ($previousResult as $item){

                $subjectName = $item->subject->title;
                $revisedPreviousResult[$subjectName] = $item->total;

            }

            foreach ($antiPreviousResult as $item){
                $subjectName = $item->subject->title;
                $antiRevisedPreviousResult[$subjectName] = $item->total;

            }
            $similarityArray = array_intersect_key($antiRevisedPreviousResult,$revisedPreviousResult);
            $antiSimilarityArray = array_intersect_key($revisedPreviousResult,$antiRevisedPreviousResult);

            foreach ($similarityArray as $key=>$item){
                $similarArrayTotalScore[] = $item;
                $label[] = $key;
            }
            foreach ($antiSimilarityArray as $item){
                $antiSimilarArrayTotalScore[] = $item;
            }


            $similarityArray = ['data' => $similarityArray , 'totalScore'=> $similarArrayTotalScore, 'label' => $term[$previousTerm_id -1]];
            $antiSimilarityArray = ['data' => $antiSimilarityArray , 'totalScore'=> $antiSimilarArrayTotalScore, 'label' => $term[$antiPreviousTerm_id -1]];

            $totalArray = [$similarityArray , $antiSimilarityArray];
            //$totalArray = array_merge_recursive($similarityArray , $antiSimilarityArray);



        }elseif ($currentTerm->id == 2){
                $previousTerm_id = 1;
                $antiPreviousTerm_id = 3;
                $previousAcademicSessionId = $currentAcademicSession->id - 1;

            $previousResult = Results::where([
                ['student_id', $req['student_id']],
                ['academic_session_id', $currentAcademicSession->id],
                ['term_id', $previousTerm_id],
            ])->orderBy('subject_id','asc')->get();

            $antiPreviousResult = Results::where([
                ['student_id', $req['student_id']],
                ['academic_session_id', $previousAcademicSessionId],
                ['term_id', $antiPreviousTerm_id],
            ])->orderBy('subject_id','asc')->get();


            foreach ($previousResult as $item){

                $subjectName = $item->subject->title;
                $revisedPreviousResult[$subjectName] = $item->total;

            }

            foreach ($antiPreviousResult as $item){
                $subjectName = $item->subject->title;
                $antiRevisedPreviousResult[$subjectName] = $item->total;

            }
            $similarityArray = array_intersect_key($antiRevisedPreviousResult,$revisedPreviousResult);
            $antiSimilarityArray = array_intersect_key($revisedPreviousResult,$antiRevisedPreviousResult);

            foreach ($similarityArray as $key=>$item){
                $similarArrayTotalScore[] = $item;
                $label[] = $key;
            }
            foreach ($antiSimilarityArray as $item){
                $antiSimilarArrayTotalScore[] = $item;
            }


            $similarityArray = ['data' => $similarityArray , 'totalScore'=> $similarArrayTotalScore, 'label' => $term[$previousTerm_id -1]];
            $antiSimilarityArray = ['data' => $antiSimilarityArray , 'totalScore'=> $antiSimilarArrayTotalScore, 'label' => $term[$antiPreviousTerm_id -1]];

            $totalArray = [$similarityArray , $antiSimilarityArray];
            //$totalArray = array_merge_recursive($similarityArray , $antiSimilarityArray);



        }elseif ($currentTerm->id == 3){
            $previousTerm_id = 2;
            $antiPreviousTerm_id = 1;

            $previousResult = Results::where([
                ['student_id', $req['student_id']],
                ['academic_session_id', $currentAcademicSession->id],
                ['term_id', $previousTerm_id],
            ])->orderBy('subject_id','asc')->get();

            $antiPreviousResult = Results::where([
                ['student_id', $req['student_id']],
                ['academic_session_id', $currentAcademicSession->id],
                ['term_id', $antiPreviousTerm_id],
            ])->orderBy('subject_id','asc')->get();


            foreach ($previousResult as $item){

                $subjectName = $item->subject->title;
                $revisedPreviousResult[$subjectName] = $item->total;

            }

            foreach ($antiPreviousResult as $item){
                $subjectName = $item->subject->title;
                $antiRevisedPreviousResult[$subjectName] = $item->total;

            }
            $similarityArray = array_intersect_key($antiRevisedPreviousResult,$revisedPreviousResult);
            $antiSimilarityArray = array_intersect_key($revisedPreviousResult,$antiRevisedPreviousResult);

            foreach ($similarityArray as $key=>$item){
                $similarArrayTotalScore[] = $item;
                $label[] = $key;
            }
            foreach ($antiSimilarityArray as $item){
                $antiSimilarArrayTotalScore[] = $item;
            }


            $similarityArray = ['data' => $similarityArray , 'totalScore'=> $similarArrayTotalScore, 'label' => $term[$previousTerm_id -1]];
            $antiSimilarityArray = ['data' => $antiSimilarityArray , 'totalScore'=> $antiSimilarArrayTotalScore, 'label' => $term[$antiPreviousTerm_id -1]];

            $totalArray = [$similarityArray , $antiSimilarityArray];
            //$totalArray = array_merge_recursive($similarityArray , $antiSimilarityArray);


        }









        return response()->json([
            'antiPreviousResult' => $antiRevisedPreviousResult,
            'previousResult' => $revisedPreviousResult,
            'totalArray' => $totalArray,
          'current term' => $currentTerm,
          'current session' => $currentAcademicSession,
            'label' => $label
        ]);


      /*  $previousTerm_id = Term::where('id',$previousTerm_id)->first();



        $results = Results::where([
            ['student_id',$req['student_id']],
            ['term_id',$req['term_id']],
            ['academic_session_id',$req['academic_session_id']]
        ])->with('subject')->get();*/


    }




    public function getStudentOrResult(Request $request){
        try {
            $res = $request->all();

            $result = Results::where('class_type_id',$res['class_type_id'])
                ->where('subject_id',$res['subject_id'])
                ->where('term_id',$res['term_id'])
                ->where('academic_session_id',$res['academic_session_id'])
                ->with(['student:id,user_id','student.user:id,name,reg_no,profile_image'])
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

        }catch (\Exception $exception){
            return response()->json(['error'=>$exception->getMessage()]);
        }


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

        try {
            $formRequest = $request->all();
            if (array_is_list($formRequest)){
                $results = Results::insert($formRequest);
                return response()->json([
                    'message'=> "${results} bulk message done successfully"
                ],200);
            }
            $results = Results::create($formRequest);

            return response(new ResultsResource($results),200);

        }catch (\Exception $exception){
            return response()->json([
                'message'=> $exception->getMessage()
            ],500);
        }

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
