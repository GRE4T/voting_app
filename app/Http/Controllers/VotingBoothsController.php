<?php

namespace App\Http\Controllers;

use App\Http\Requests\VotingBooths\StoreVotingBoothsRequest;
use App\Http\Requests\VotingBooths\UpdateVotingBoothsRequest;
use App\Models\VotingBooth;

class VotingBoothsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.votingBooths.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.votingBooths.create', [
            'votingBooth' => new VotingBooth
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VotingBooths\StoreVotingBoothsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVotingBoothsRequest $request)
    {
        $votingBooth = new VotingBooth();
        $votingBooth->user_id = $request->user()->id;
        $votingBooth->name = $request->name;
        $votingBooth->number_tables = $request->number_tables;
        $votingBooth->save();

        return redirect()->route('voting-booths.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VotingBooth  $votingBooth
     * @return \Illuminate\Http\Response
     */
    public function show(VotingBooth $votingBooth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VotingBooth  $votingBooth
     * @return \Illuminate\Http\Response
     */
    public function edit(VotingBooth $votingBooth)
    {
        return view('pages.votingBooths.edit', [
            'votingBooth' => $votingBooth
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\VotingBooths\UpdateVotingBoothsRequest  $request
     * @param  \App\Models\VotingBooth  $votingBooth
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVotingBoothsRequest $request, VotingBooth $votingBooth)
    {
        $votingBooth->user_id = $request->user()->id;
        $votingBooth->name = $request->name;
        $votingBooth->number_tables = $request->number_tables;
        $votingBooth->update();

        return redirect()->route('voting-booths.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VotingBooths  $votingBooths
     * @return \Illuminate\Http\Response
     */
    public function destroy(VotingBooths $votingBooths)
    {
        $votingBooths->delete();
        return redirect()->route('voting-booths.index');
    }
}
