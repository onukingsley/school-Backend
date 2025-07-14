<?php

namespace App\Http\Controllers;

use App\Http\Resources\StaffRoleCollection;
use App\Http\Resources\StaffRoleResource;
use App\Models\StaffRole;
use Illuminate\Http\Request;

class StaffRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $filter = new \App\Services\v1\StaffRole();

         $query = $filter->transform($request);

         $staffRole = StaffRole::where($query);

         $include = [];

         if ($request->has('classType')){
             $include[] = 'ClassType';
         }
         if ($request->has('Subject')){
             $include[] = 'Subject';
         }

         $staffRole = $staffRole->with($include);

         return new StaffRoleCollection($staffRole->latest()->paginate()->appends($request->query()));


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
        $staffRole = StaffRole::create($formRequest);

        return response(new StaffRoleResource($staffRole),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffRole $staffRole, Request $request)
    {
        $include = [];
        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }

        $staffRole = $staffRole->with($include);
        return response()->json(new StaffRoleResource($staffRole),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffRole $staffRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffRole $staffRole)
    {
        $staffRole = $staffRole->update($request->all());
        return response()->json($staffRole,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffRole $staffRole)
    {
        $title = $staffRole->role;
        $staffRole->delete();
        return response()->json(['message'=>"Staff-Role: {$title} was deleted successfully"],200);
    }
}
