<?php

namespace App\Models;

use App\Models\User;
use App\Models\FanQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cosplayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cosplayer_name',
    ];

    /**
     * Get the user that owns the cosplayer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the fan queues associated with the cosplayer.
     */
    public function fanQueues()
    {
        return $this->hasMany(FanQueue::class);
    }
}
