<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuardianCollection;
use App\Http\Resources\GuardianResource;
use App\Models\Assignment;
use App\Models\Guardian;
use App\Services\v1\AssignmentQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AssignmentQuery();

        $query = $filter->transform($request);

        $guardian = Guardian::where($query);

        $include = [];

        if ($request->has('User')){
            $include[] = 'User';
        }
        if ($request->has('Student')){
            $include[] = 'Student';
        }


        $guardian = $guardian->with($include);

        return new GuardianCollection($guardian->paginate()->appends($request->query()));


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
        $guardian = Guardian::create($formRequest);

        return response(new GuardianResource($guardian),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guardian $guardian, Request $request)
    {
        $include = [];
        if ($request->has('User')){
            $include[] = 'User';
        }
        if ($request->has('Student')){
            $include[] = 'Student';
        }

        $guardian = $guardian->with($include);
        return response()->json(new GuardianResource($guardian),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guardian $guardian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guardian $guardian)
    {
        $guardian = $guardian->update($request->all());
        return response()->json($guardian,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {

        $guardian->delete();
        return response()->json(['message'=>"Guardian deleted successfully"],200);
    }
}
