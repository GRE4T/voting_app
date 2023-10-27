<?php

namespace App\Http\Controllers;

use App\Http\Requests\Records\StoreRecordRequest;
use App\Http\Requests\Records\UpdateRecordRequest;
use App\Models\Party;
use App\Models\Record;
use App\Models\Vote;
use App\Models\VotingBooth;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.votes.index', [
            'votingBooths' => VotingBooth::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.votes.create', [
            'record' => new Record,
            'votingBooths' => VotingBooth::all(),
            'parties' => Party::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Records\StoreRecordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecordRequest $request)
    {
        DB::transaction(function () use ($request) {
            $record = new Record();
            $record->user_id = $request->user()->id;
            $record->voting_booth_id = $request->voting_booth_id;
            $record->number_table = $request->number_table;
            $record->save();

            foreach ($request->votes as $party => $item) {
                foreach ($item as $key => $value) {
                    Vote::create([
                        'record_id' => $record->id,
                        'party_id' => $party,
                        'number_candidate' => $key,
                        'votes' => $value
                    ]);
                }
            }
        });


        return redirect()->route('records.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        return view('pages.votes.edit', [
            'record' => $record,
            'votingBooths' => VotingBooth::all(),
            'parties' => Party::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Records\UpdateRecordRequest $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecordRequest $request, Record $record)
    {
        DB::transaction(function () use ($request, $record) {
            $record->user_id = $request->user()->id;
            $record->voting_booth_id = $request->voting_booth_id;
            $record->number_table = $request->number_table;
            $record->update();

            foreach ($request->votes as $party => $item) {
                foreach ($item as $key => $value) {
                    Vote::updateOrCreate(
                        [
                            'record_id' => $record->id,
                            'party_id' => $party,
                            'number_candidate' => $key
                        ],
                        [
                            'votes' => $value
                        ]
                    );
                }
            }
        });

        return redirect()->route('records.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return redirect()->route('records.index');
    }
}
