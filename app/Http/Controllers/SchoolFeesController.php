<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolFeesCollection;
use App\Http\Resources\SchoolFeesResource;
use App\Models\SchoolFees;
use App\Services\v1\SchoolFeesQuery;
use Illuminate\Http\Request;

class SchoolFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new SchoolFeesQuery();

        $query = $filter->transform($request);

        $schoolFees = SchoolFees::where($query);

        $include = [];

        if ($request['Student']){
            $include[] = 'Student';
        }
        if ($request['Dues']){
            $include[] = 'Dues';
        }
        if ($request['AcademicSession']){
            $include[] = 'AcademicSession';
        }
        if ($request['Term']){
            $include[] = 'Term';
        }

        $schoolFees = $schoolFees->with($include);

        return response()->json(($schoolFees->latest()->paginate()->appends($request->query())),200);
       // return new SchoolFeesCollection($schoolFees->latest()->paginate()->appends($request->query()));


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
        $schoolFees = SchoolFees::create($formRequest);

        return response(new SchoolFeesResource($schoolFees),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolFees $schoolFees, Request $request)
    {
        $include = [];
        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }

        $schoolFees = $schoolFees->with($include);
        return response()->json(new SchoolFeesResource($schoolFees),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolFees $schoolFees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolFees $schoolFees)
    {
        $schoolFees = $schoolFees->update($request->all());
        return response()->json($schoolFees,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolFees $schoolFees)
    {
        $transaction_id = $schoolFees->transaction_id;
        $schoolFees->delete();
        return response()->json(['message'=>"SchoolFees history with: {$transaction_id} was deleted successfully"],200);
    }
}
