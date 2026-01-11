<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\v1\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new UserQuery();

        $query = $filter->transform($request);

        $user = User::where($query);

        $include = [];

        if ($request['staff']){
            $include[] = 'Staff';
        }
        if ($request['student']){
            $include[] = 'Student';
        }
        if ($request['guardian']){
            $include[] = 'Guardian';
        }


        $user = $user->with($include);

        return response()->json($user->latest()->paginate(10)->appends($request->query()),200);

        //return response()->json($user->latest()->paginate(10)->appends($request->query()));


    }

    public function getusertype($usertype){
        //switch statement to determine the scope where 2 is admin, 1 is seller and 0 is customer
        switch ($usertype){
            case '2':
                return ['create','update','delete','updateProduct','deleteProduct','deleteUser','suspend'];

            case '1':
                return ['create','update','updateProduct','deleteProduct','deleteStore'];

            case '0':
                return ['create','update','deleteProfile'];
            default:
                return ['create','update'];

        }
    }
    public function getuser(Request $request){
        $payload = $request->all();

        if ($request->has('id')){
            $user = User::where('id',$payload['id'])->with(['Student','Staff'])->get();
        }
        else{
            $user = $request->user();;
        }

        return \response()->json($user);
    }

    public function login(Request $request){

        $username = $request->username;
        $password = $request->password;


        $user = User::where('email',$username )->orwhere('reg_no',$username)->first();

        if ($user && Hash::check($password,$user->password)){
            auth()->login($user);

            $token = $user->createToken($user->email,$this->getusertype($user->user_type))->plainTextToken;

            return response()->json(['user' => $user, 'token'=>$token, 'message'=>'Login Successful'],200);

        }else{
            return response()->json(['message'=>'Invalid User Credential'],401);
        }


    }

    public function register(Request $request){
        $formRequest = $request->all();

        $hashedpassword = Hash::make($formRequest['password']);
        $requestname = $formRequest['name'];

        $formRequest['password'] = $hashedpassword;


        $user = User::create($formRequest);

        if ($user){
            auth()->login($user);
            $token = $user->createToken($user->email,$this->getusertype($user->user_type))->plainTextToken;

            return response()->json(['user' => $user, 'token'=> $token, 'message'=>"User record $user->name created successfully"],200);

        }else{
            return response()->json(["message'=>'unable to create user $requestname"]);
        }


    }

    public function logout(Request $request){
        try {
            $user = $request->user();

            $user->currentAccessToken()->delete();

            return response()->json(['message'=>'You have been logged out']);
        }catch (\Exception $exception){
            return response()->json($exception,401);
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
        $user = User::create($formRequest);

        return response(new UserResource($user),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        $include = [];
        if ($request['classType']){
            $include[] = 'ClassType';
        }
        if ($request['subject']){
            $include[] = 'Subject';
        }
        if ($request['staff']){
            $include[] = 'Staff';
        }
        if ($request['term']){
            $include[] = 'Term';
        }
        if ($request['academicSession']){
            $include[] = 'AcademicSession';
        }


        $user = $user->loadMissing($include);
        return response()->json($user,200);

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = $user->update($request->all());
        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $title = $user->name;
        $user->delete();
        return response()->json(['message'=>"User record: {$title} waas deleted successfully"],200);
    }
}
