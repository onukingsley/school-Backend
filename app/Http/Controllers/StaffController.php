<?php

namespace App\Http\Controllers;

use App\Http\Resources\StaffCollection;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use App\Services\v1\StaffQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new StaffQuery();

        $query = $filter->transform($request);

        $staff = Staff::where($query);

        $include = [];

        if ($request->has('Dues')){
            $include[] = 'Dues';
        }
        if ($request->has('StaffRole')){
            $include[] = 'StaffRole';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('ExamTable')){
            $include[] = 'ExamTable';
        }
        if ($request->has('SubjectCode')){
            $include[] = 'SubjectCode';
        }

        $staff = $staff->with($include);

        return new StaffCollection($staff->latest()->paginate()->appends($request->query()));


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
        $staff = Staff::create($formRequest);

        return response(new StaffResource($staff),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff, Request $request)
    {
        $include = [];
        if ($request->has('Dues')){
            $include[] = 'Dues';
        }
        if ($request->has('StaffRole')){
            $include[] = 'StaffRole';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('ExamTable')){
            $include[] = 'ExamTable';
        }
        if ($request->has('SubjectCode')){
            $include[] = 'SubjectCode';
        }

        $staff = $staff->with($include);
        return response()->json(new StaffResource($staff),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $staff = $staff->update($request->all());
        return response()->json($staff,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $title = $staff->id;
        $staff->delete();
        return response()->json(['message'=>"Staff with ID: {$title} was deleted successfully"],200);
    }
}
