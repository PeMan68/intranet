<?php

namespace App\Http\Controllers;

use App\Demoproduct;
use App\TrackDemoproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackDemoproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $data ['demoproduct_id'] = $request->itemId;
            $data ['to_location_id'] = $request->toLocation;
            $data ['from_location_id'] = $request->fromLocation;
            $data ['user_id'] = $request->user;
            $data ['comment'] = $request->reason;

            $track = TrackDemoproduct::create($data);

            // Update produktinfo
            $product = Demoproduct::find($request->itemId);
            
            $product->location_id = $request->toLocation;
            $product->status_id = $request->status;
            $product->original_box = $request->box == 'Yes' ? true : false;
            $product->original_docs = $request->doc == 'Yes' ? true : false;
            $product->tested = $request->tested == 'Yes' ? true : false;
            $product->serial = $request->serial;
            $product->version = $request->version;
                        
            $product->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrackDemoproduct  $trackDemoproduct
     * @return \Illuminate\Http\Response
     */
    public function show(TrackDemoproduct $trackDemoproduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrackDemoproduct  $trackDemoproduct
     * @return \Illuminate\Http\Response
     */
    public function edit(TrackDemoproduct $trackDemoproduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrackDemoproduct  $trackDemoproduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrackDemoproduct $trackDemoproduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrackDemoproduct  $trackDemoproduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrackDemoproduct $trackDemoproduct)
    {
        //
    }
}
