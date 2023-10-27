<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected  $fillable = [
        'record_id',
        'party_id',
        'number_candidate',
        'votes'
    ];

    protected $with = [
        'party'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

}
