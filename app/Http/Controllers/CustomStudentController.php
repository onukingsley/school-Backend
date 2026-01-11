<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassType;
use App\Models\Results;
use App\Models\Session;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Http\Request;

class CustomStudentController extends Controller
{


    public function studentOverview(Request $request){
        $req = $request->all();

        //$currentAcademicSession = Session::latest()->first();
        $currentAcademicSession = Session::orderBy('id','desc')->first();
        $currentTerm = Term::where('current_term','1')->first();

        if (!$currentTerm || !$currentAcademicSession){
            return response()->json(['message'=>"Current academic Session or Term not set", 500]);
        }


        $studentDetails = Student::with([
            'ClassType',
            'Attendance' => function($q)use($currentAcademicSession,$currentTerm){
                $q->where([
                    ['term_id', $currentTerm->id],
                    ['academic_session_id', $currentTerm->id],
                ]);
            },
            'ClassType.Assignment'=> function($q)use($currentAcademicSession,$currentTerm){
                $q->where([
                    ['term_id', $currentTerm->id],
                    ['academic_session_id', $currentTerm->id],
                ]);
            },
            'Result'=> function($q)use($currentAcademicSession,$currentTerm){
                $q->where([
                    ['term_id', $currentTerm->id],
                    ['academic_session_id', $currentTerm->id],
                ]);
            },
            'Guardian'


        ])->where('user_id', $req['user_id'])->first();


        $presentAttendance = $studentDetails->Attendance->where('attendance',1)->count();
        $totalAttendance = $studentDetails->Attendance->count();

        $comparison = Results::where([
           ['student_id',$studentDetails->id],
            ['term_id', $currentTerm->id],
            ['academic_session_id', $currentAcademicSession->id],
        ])->with("subject")->get();

        $label = [];
        $assignment1 = [];
        $assignment2 = [];
        $test1 = [];
        $test2 = [];

        foreach ($comparison as $res){
            $label = [...$label, $res->subject->title];
            $test1 = [...$test1, $res->test1];
            $test2 = [...$test2, $res->test2];


            $assignment1 = [...$assignment1, $res->assignment1];
            $assignment2 = [...$assignment2, $res->assignment2];

        }
        $test = [
            'label_type' => 'test',
            'label' => $label,

            'inputData' => [
                ['data'=>$test1, 'labelType'=>'test1']
                ,
                ['data'=>$test2, 'labelType'=>'test2']

            ]
        ];
        $assignmentfinal = [
            'label_type' => 'assignment',
            'label' => $label,

            'inputData' =>[
                ['data'=>$assignment1, 'labelType'=>'assignment1']

                ,
                ['data'=>$assignment2, 'labelType'=>'assignment2']

            ]

        ];





        /*get Comparison Data from two previous terms*/



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
                ['student_id', $studentDetails->id],
                ['academic_session_id', $previousSession],
                ['term_id', $previousTerm_id],
            ])->orderBy('subject_id','asc')->with('subject')->get();


            $antiPreviousResult = Results::where([
                ['student_id', $studentDetails->id],
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
                ['student_id', $studentDetails->id],
                ['academic_session_id', $currentAcademicSession->id],
                ['term_id', $previousTerm_id],
            ])->orderBy('subject_id','asc')->get();

            $antiPreviousResult = Results::where([
                ['student_id', $studentDetails->id],
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
                ['student_id', $studentDetails->id],
                ['academic_session_id', $currentAcademicSession->id],
                ['term_id', $previousTerm_id],
            ])->orderBy('subject_id','asc')->get();

            $antiPreviousResult = Results::where([
                ['student_id', $studentDetails->id],
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

        /*Get and select the Pending Assignments*/

        $result = Results::with(['student:id,user_id','student.user:id,name,reg_no,profile_image'])
            ->select('term_id', 'academic_session_id', 'student_id', 'subject_id', 'class_type_id', 'assignment1', 'assignment2')
            ->where([['student_id',$studentDetails->id],
                ['term_id',$currentTerm->id],
                ['academic_session_id',$currentAcademicSession->id],

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

        /*get subjects*/

        $class_type = ClassType::where('id', $studentDetails->classType->id)->get();



        $subjectList = [];


        foreach ($class_type[0]['subject'] as $item){
            //$subject = Subject::where('id',$item)->with(['Staff:id,user_id','Staff.user:id,name,reg_no,profile_image'])->get();
            $subject = Subject::where('title',$item)->with(['Staff:id,user_id','Staff.user:id,name,reg_no,profile_image'])->get();

            if ($subject){
                $subjectList[] = $subject;
            }
        }








        $response = [
          'comparisonChart' => [
              'antiPreviousResult' => $antiRevisedPreviousResult,
              'previousResult' => $revisedPreviousResult,
              'totalArray' => $totalArray,
              'current term' => $currentTerm,
              'current session' => $currentAcademicSession,
              'label' => $label
          ],
           'testAndAssignmentChart' => [
               'test'=>$test,'assignment'=>$assignmentfinal
           ],
            'pendingAssignment' => [
                'missing assignment' => $result,
                'pendingAssignment' => $assignment,
                'countOfPendingAssignment' =>$assignment ? $assignment->count(): 0
            ],
            'attendance' => [
                'attended'=>$presentAttendance,
                'missingAttendance' => $totalAttendance - $presentAttendance,
                'totalAttendance' => $totalAttendance
            ],
            'studentDetail'=>$studentDetails,
            'classType' => $studentDetails->classType,
            //'subject' => $studentDetails->classType->subject,
            'subject' => $subjectList,
            'assignment' => $studentDetails->ClassType->Assignment,
            'term' => $currentTerm,
            'academicSession' => $currentAcademicSession,
            'result'=> $result

        ];

        return response()->json($response,200);






    }

}
