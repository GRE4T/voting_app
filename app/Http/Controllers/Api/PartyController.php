<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Party;
use DataTables;

class PartyController extends Controller
{
    public function  index()
    {
        return Datatables::of(Party::query()->get()->load('user'))->make(true);
    }

    public function  destroy(Party $party)
    {
        $party->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully executed',
            'data' => $party
        ], 200);
    }
}
