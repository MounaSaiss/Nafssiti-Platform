<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'follow_request_id',
        'content'
    ];

    public function followRequest()
    {
        return $this->belongsTo(FollowRequest::class);
    }
}
