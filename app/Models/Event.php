<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_date',
        'location',
        'description',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)->withTimestamps();
    }
}
