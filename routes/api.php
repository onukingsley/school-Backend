<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassTypeController;
use App\Http\Controllers\CustomStaffController;
use App\Http\Controllers\CustomStudentController;
use App\Http\Controllers\DuesController;
use App\Http\Controllers\ExamTableController;
use App\Http\Controllers\GradeScaleController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResultsCheckController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\SchoolFeesController;
use App\Http\Controllers\SchoolInfoController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffRoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix'=>'v1'/*,'middleware'=>'auth:sanctum'*/],function(){
    Route::apiResource('assignment',AssignmentController::class);
    Route::apiResource('attendance',AttendanceController::class);
    Route::apiResource('classType',ClassTypeController::class);
    Route::apiResource('dues',DuesController::class);
    Route::apiResource('examTable',ExamTableController::class);
    Route::apiResource('gradeScale',GradeScaleController::class);
    Route::apiResource('guardian',GuardianController::class);
    Route::apiResource('notice',NoticeController::class);
    Route::apiResource('payment',PaymentController::class);
    Route::apiResource('resultsCheck',ResultsCheckController::class);
    Route::apiResource('results',ResultsController::class);
    Route::apiResource('salaryPayment',SalaryPaymentController::class);
    Route::apiResource('schoolFees',SchoolFeesController::class);
    Route::apiResource('schoolInfo',SchoolInfoController::class);
    Route::apiResource('academicSession',SessionController::class);
    Route::apiResource('staff',StaffController::class);
    Route::apiResource('staffRole',StaffRoleController::class);
    Route::apiResource('student',StudentController::class);
    Route::apiResource('subject',SubjectController::class);
    Route::apiResource('term',TermController::class);
    Route::apiResource('timeTable',TimetableController::class);
    Route::apiResource('users',UserController::class);
});

Route::post('v1/login',[UserController::class,'login']);
Route::post('v1/register',[UserController::class,'register']);
Route::post('v1/logout',[UserController::class,'logout'])->middleware('auth:sanctum');
Route::get('v1/user',[UserController::class,'getuser'])->middleware('auth:sanctum');
Route::get('v1/getStudentDetail',[StudentController::class,'getStudent'])->middleware('auth:sanctum');
Route::get('v1/getSubject',[ClassTypeController::class,'getSubject'])->middleware('auth:sanctum');

/*
 * Custom EndPoints
 * getPendingAssignment
 * getStudentOrResult for result-sheet
 * upsertToDB update Result from Database
 * */
Route::get('v1/getPendingAssignment',[ResultsController::class,'getPendingAssignment']);
Route::get('v1/getStudentOrResult',[ResultsController::class,'getStudentOrResult']);
Route::get('v1/getCurrentTermAndSession',[SessionController::class,'getCurrentTermAndSession']);
Route::get('v1/getAttendance',[AttendanceController::class,'getAttendance']);
Route::post('v1/upsertToDB',[ResultsController::class,'upsertToDB']);
Route::get('v1/getClassType',[ClassTypeController::class,'getClassType']);
Route::get('v1/getTestAndAssignmentData',[ResultsController::class,'getTestAndAssignmentData']);
Route::get('v1/getComparisonData',[ResultsController::class,'getComparisonData']);
Route::get('v1/getStudentResult',[ResultsController::class,'getStudentResult']);




/*for Staff endPoints*/
Route::get('v1/getStaffOverview',[CustomStaffController::class,'getIndexOverview']);
Route::get('v1/getStudentOverview',[CustomStudentController::class,'studentOverview']);


