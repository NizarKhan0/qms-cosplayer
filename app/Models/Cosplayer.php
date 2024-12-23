<?php

namespace App\Models;

use App\Models\User;
use App\Models\FanQueue;
use Illuminate\Support\Str;
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

    // Add this accessor to get current queue count
    public function getCurrentQueueCountAttribute()
    {
        return $this->fanQueues()
            ->where('status', 'Pending')
            ->count();
    }

    // In Cosplayer model
    public static function boot()
    {
        parent::boot();

        static::creating(function ($cosplayer) {
            $cosplayer->slug = Str::slug($cosplayer->cosplayer_name);
        });

        static::updating(function ($cosplayer) {
            $cosplayer->slug = Str::slug($cosplayer->cosplayer_name);
        });
    }
}
