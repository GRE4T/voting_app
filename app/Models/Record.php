<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected  $fillable = [
        'user_id',
        'voting_booth_id',
        'number_table',
        'image'
    ];

    protected $appends = [
        'votes_cast',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getVotesCastAttribute()
    {
        return $this->votes()->get()->groupBy('party_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function  votingBooth()
    {
        return $this->belongsTo(VotingBooth::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
