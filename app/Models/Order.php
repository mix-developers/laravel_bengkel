<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class, 'id_part', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service', 'id');
    }
}
