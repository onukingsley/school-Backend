<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalaryPaymentCollection;
use App\Http\Resources\SalaryPaymentResource;
use App\Models\SalaryPayment;
use App\Services\v1\SalaryPaymentQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new SalaryPaymentQuery();

        $query = $filter->transform($request);

        $salaryPayment = SalaryPayment::where($query);

        $include = [];

        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('Dues')){
            $include[] = 'Dues';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }

        $salaryPayment = $salaryPayment->with($include);

        return new SalaryPaymentCollection($salaryPayment->latest()->paginate()->appends($request->query()));


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
        $salaryPayment = SalaryPayment::create($formRequest);

        return response(new SalaryPaymentResource($salaryPayment),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalaryPayment $salaryPayment, Request $request)
    {
        $include = [];
        if ($request->has('Student')){
            $include[] = 'Student';
        }
        if ($request->has('Dues')){
            $include[] = 'Dues';
        }
        if ($request->has('AcademicSession')){
            $include[] = 'AcademicSession';
        }
        if ($request->has('Term')){
            $include[] = 'Term';
        }

        $salaryPayment = $salaryPayment->with($include);
        return response()->json(new SalaryPaymentResource($salaryPayment),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalaryPayment $salaryPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalaryPayment $salaryPayment)
    {
        $salaryPayment = $salaryPayment->update($request->all());
        return response()->json($salaryPayment,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalaryPayment $salaryPayment)
    {
        $title = $salaryPayment->name;
        $salaryPayment->delete();
        return response()->json(['message'=>"Salary record of: {$title} was deleted successfully"],200);
    }
}
