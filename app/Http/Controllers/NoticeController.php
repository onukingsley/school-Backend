<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoticeCollection;
use App\Http\Resources\NoticeResource;
use App\Models\Notice;
use App\Services\v1\NoticeQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new NoticeQuery();

        $query = $filter->transform($request);

        $notice = Notice::where($query)->get();


        return new NoticeCollection($notice->latest()->paginate()->appends($request->query()));


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
        $notice = Notice::create($formRequest);

        return response(new NoticeResource($notice),200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {

        return response()->json(new NoticeResource($notice),200);

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $notice = $notice->update($request->all());
        return response()->json($notice,200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $title = $notice->title;
        $notice->delete();
        return response()->json(['message'=>"Notice: {$title} deleted successfully"],200);
    }
}
