<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePayment extends Model
{
    use HasFactory;
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service', 'id');
    }
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'id_bank', 'id');
    }
}
