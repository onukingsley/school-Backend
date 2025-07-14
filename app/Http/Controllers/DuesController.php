<?php

namespace App\Http\Controllers;

use App\Http\Resources\DuesCollection;
use App\Http\Resources\DuesResource;
use App\Models\Dues;
use App\Services\v1\DuesQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DuesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new DuesQuery();

        $query = $filter->transform($request);

        $dues = Dues::where($query);

        $include = [];

        if ($request->has('SchoolFees')){
            $include[] = 'SchoolFees';
        }
        if ($request->has('SalaryPayment')){
            $include[] = 'SalaryPayment';
        }
        if ($request->has('ResultCheck')){
            $include[] = 'ResultCheck';
        }

        $dues = $dues->with($include);

        return new DuesCollection($dues->latest()->paginate()->appends($request->query()));


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
        $dues = Dues::create($formRequest);

        return response(new DuesResource($dues),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dues $dues, Request $request)
    {
        $include = [];
        if ($request->has('SchoolFees')){
            $include[] = 'SchoolFees';
        }
        if ($request->has('SalaryPayment')){
            $include[] = 'SalaryPayment';
        }
        if ($request->has('ResultCheck')){
            $include[] = 'ResultCheck';
        }

        $dues = $dues->with($include);
        return response()->json(new DuesResource($dues),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dues $dues)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dues $dues)
    {
        $dues = $dues->update($request->all());
        return response()->json($dues,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dues $dues)
    {
        $title = $dues->title;
        $dues->delete();
        return response()->json(['message'=>"Dues: {$title} deleted successfully"],200);
    }
}
