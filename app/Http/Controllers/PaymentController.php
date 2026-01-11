<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\v1\PaymentQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PaymentQuery();

        $query = $filter->transform($request);

        $payment = Payment::where($query)->get();




        return new PaymentCollection($payment->latest()->paginate()->appends($request->query()));


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
        $payment = Payment::create($formRequest);

        return response(new PaymentResource($payment),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment, Request $request)
    {
        $include = [];
        if ($request->has('classType')){
            $include[] = 'ClassType';
        }
        if ($request->has('Subject')){
            $include[] = 'Subject';
        }

        $payment = $payment->with($include);
        return response()->json(new PaymentResource($payment),200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $payment = $payment->update($request->all());
        return response()->json($payment,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $title = $payment->transaction_name;
        $payment->delete();
        return response()->json(['message'=>"Payment History: {$title} deleted successfully"],200);
    }
}
