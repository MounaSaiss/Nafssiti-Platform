<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TherapeuticObjective extends Model
{
    protected $fillable = [
        'follow_request_id',
        'description',
        'status'
    ];

    public function followRequest()
    {
        return $this->belongsTo(FollowRequest::class);
    }
}
