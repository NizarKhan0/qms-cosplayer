<?php

namespace App\Models;

use App\Models\Fan;
use App\Models\Cosplayer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FanQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'fan_id',
        'cosplayer_id',
        'queue_number',
        'status',
    ];

    /**
     * Get the fan that owns the fan queue.
     */
    public function fan()
    {
        return $this->belongsTo(Fan::class);
    }

    /**
     * Get the cosplayer that owns the fan queue.
     */
    public function cosplayer()
    {
        return $this->belongsTo(Cosplayer::class);
    }
}
