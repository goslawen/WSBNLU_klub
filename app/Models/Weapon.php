<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weapon extends Model
{
    protected $fillable = [
        'weapon_type_id',
        'name',
        'caliber',
        'serial_number',
        'status',
    ];

    public function weaponType(): BelongsTo
    {
        return $this->belongsTo(WeaponType::class);
    }
}
