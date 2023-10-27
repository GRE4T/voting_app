<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parties\StorePartyRequest;
use App\Http\Requests\Parties\UpdatePartyRequest;
use App\Models\Party;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('pages.parties.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.parties.create', [
            'party' => new Party
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Parties\StorePartyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartyRequest $request)
    {
        $party = new Party();
        $party->user_id = $request->user()->id;
        $party->name = $request->name;
        $party->number_candidates = $request->number_candidates;
        $party->save();

        return redirect()->route('parties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        return view('pages.parties.edit', [
            'party' => $party
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Parties\UpdatePartyRequest  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartyRequest $request, Party $party)
    {
        $party->user_id = $request->user()->id;
        $party->name = $request->name;
        $party->number_candidates = $request->number_candidates;
        $party->update();

        return redirect()->route('parties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        $party->delete();

        return redirect()->route('parties.index');
    }
}
