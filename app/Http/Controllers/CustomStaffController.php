<?php

namespace App\Http\Controllers;

use App\Models\SalaryPayment;
use App\Models\Session;
use App\Models\Staff;
use App\Models\Term;
use Illuminate\Http\Request;

class CustomStaffController extends Controller
{
    /*
     * this would contain the following data key
     * -staff info
     * - timeTable
     * - progress chart for the various subject
     * -if form Teacher, class Information and data
     * */

    /*this function takes in a request which takes in a user_id*/
    public function getIndexOverview(Request $request){
        $req = $request->all();

        $currentAcademicSession = Session::latest()->first();
        $currentTerm = Term::where('current_term','1')->first();

        if (!$currentTerm || !$currentAcademicSession){
            return response()->json(['message'=>"Current academic Session or Term not set", 500]);
        }


        $staff = Staff::with([
            'User',
            'StaffRole',
            'Subject',
            'StaffAttendance'=> function($query) use ($currentAcademicSession,$currentTerm){
                $query->where([
                    ['term_id',$currentTerm->id ],
                    ['attendance',1 ],
                    ['academic_session_id', $currentAcademicSession->id]
                ]);
            },
            'ExamTable'=> function($query) use ($currentAcademicSession,$currentTerm){
                $query->where([
                    ['term_id',$currentTerm->id ],
                    ['academic_session_id', $currentAcademicSession->id]
                ]);
            },
            'TimeTable'=> function($query) use ($currentAcademicSession,$currentTerm){
                $query->where([
                    ['term_id',$currentTerm->id ],
                    ['academic_session_id', $currentAcademicSession->id]
                ]);
            },
            'SalaryPayment',
            'ClassType.Student',
            'Subject.assignment'
            /*'Subject.Assignment' => function ($query) use ($currentAcademicSession,$currentTerm) {
                $query->where([
                    ['term_id',$currentTerm->id ],
                    ['academic_session_id', $currentAcademicSession->id]
                ]);
            }*/
        ])->where("user_id", $req['user_id'])->first();

        if(!$staff){
            return response()->json(["message"=>'User is not a Staff'],200);
        }


        /*gets the no of Student in the class if the staff is a form teacher
            adding "flatMap" tells laravel that it's a collection
        */



        $response = [
          'staff'=> $staff,
          'staffRole' =>  $staff->StaffRole,
          'user' => $staff->User,
          'subject'=> $staff->Subject,
          'examTable' => $staff->ExamTable,
          'timeTable' => $staff->TimeTable,
           'salaryPayment' => $staff->SalaryPayment,
            'assignment' => $staff->Subject->flatMap->Assignment,
            'attendance' => $staff->StaffAttendance->count()
        ];

        /*if Class Teacher add the following to the response*/
        if ($staff->ClassType){
            $response['classDetails'] = $staff->ClassType;
            $response['studentList'] = $staff->ClassType->Student;
            $response['studentCount'] = $staff->ClassType->Student->count();
        }


        return response()->json(['message'=>$response],200);

    }

}
