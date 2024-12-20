<?php

namespace App\Models;

use App\Models\FanQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the fan queues associated with the fan.
     */
    public function fanQueues()
    {
        return $this->hasMany(FanQueue::class);
    }
}
