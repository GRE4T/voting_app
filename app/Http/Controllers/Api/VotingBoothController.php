<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VotingBooth;
use Yajra\DataTables\DataTables;

class VotingBoothController extends Controller
{
    public function  index()
    {
        return Datatables::of(VotingBooth::query()->get()->load('user'))->make(true);
    }

    public function destroy(VotingBooth $votingBooth)
    {
        $votingBooth->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully executed',
            'data' => $votingBooth
        ], 200);
    }
}
