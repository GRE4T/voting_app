<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Votes\FilterRecordRequest;
use App\Models\Record;
use Yajra\DataTables\DataTables;

class RecordController extends Controller
{
    public function index(FilterRecordRequest $request)
    {
        $query = Record::query();
        if (isset($request->filters)) {
            $filters = $request->filters;

            foreach ($filters as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                }else{
                    $query->where($key, $value);
                }
            }
        }

        $data = $query->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully executed',
            'data' => [
                'grid' => DataTables::of($data->load('user', 'votingBooth'))->toJson(),
                'total' => $data->sum(function ($record) {
                    return $record->votes->sum('votes');
                })
            ]
        ], 200);
    }

    public function destroy(Record $record)
    {
        $record->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully executed',
            'data' => $record
        ], 200);
    }
}
