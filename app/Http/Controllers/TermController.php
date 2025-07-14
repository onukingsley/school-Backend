<?php

namespace App\Http\Controllers;

use App\Http\Resources\TermCollection;
use App\Http\Resources\TermResource;
use App\Models\Term;
use App\Services\v1\TermQuery;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new TermQuery();

        $query = $filter->transform($request);

        $term = Term::where($query);

        $include = [];

        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('SchoolFees')){
            $include[] = 'SchoolFees';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('Assignment')){
            $include[] = 'Assignment';
        }
        if ($request->has('ExamTable')){
            $include[] = 'ExamTable';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }

        $term = $term->with($include);

        return new TermCollection($term->latest()->paginate()->appends($request->query()));


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
        $term = Term::create($formRequest);

        return response(new TermResource($term),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term, Request $request)
    {
        $include = [];
        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('Attendance')){
            $include[] = 'Attendance';
        }
        if ($request->has('SchoolFees')){
            $include[] = 'SchoolFees';
        }
        if ($request->has('Result')){
            $include[] = 'Result';
        }
        if ($request->has('TimeTable')){
            $include[] = 'TimeTable';
        }
        if ($request->has('Assignment')){
            $include[] = 'Assignment';
        }
        if ($request->has('ExamTable')){
            $include[] = 'ExamTable';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }

        $term = $term->with($include);
        return response()->json(new TermResource($term),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term)
    {
        $term = $term->update($request->all());
        return response()->json($term,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term)
    {
        $title = $term->name;
        $term->delete();
        return response()->json(['message'=>"Term deleted Successfully: {$title} deleted successfully"],200);
    }
}
