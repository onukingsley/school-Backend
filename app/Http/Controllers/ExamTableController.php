<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamCollection;
use App\Http\Resources\ExamResource;
use App\Models\ExamTable;
use App\Services\v1\ExamTableQuery;
use Illuminate\Http\Request;

class ExamTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ExamTableQuery();

        $query = $filter->transform($request);

        $examTable = ExamTable::where($query);

        $include = [];

        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Session')){
            $include[] = 'Session';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }

        $examTable = $examTable->with($include);

        return new ExamCollection($examTable->latest()->paginate()->appends($request->query()));


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
        $examTable = ExamTable::create($formRequest);

        return response()->json($examTable,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamTable $examTable, Request $request)
    {
        $include = [];

        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }
        if ($request->has('Staff')){
            $include[] = 'Staff';
        }
        if ($request->has('Session')){
            $include[] = 'Session';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }

        $examTable = $examTable->with($include);

        return response(new ExamResource($examTable),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamTable $examTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamTable $examTable)
    {
        $formRequest = $request->all();
        $examTable = $examTable->update($formRequest);

        return response()->json($examTable,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamTable $examTable)
    {

            $examTable->delete();
            return response()->json(['message'=>"Exam was deleted successfully"],200);

    }
}
