<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceStatus extends Model
{
    use HasFactory;

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public static function getStatus($id_service)
    {
        return self::with('service')
            ->where('id_service', $id_service)
            ->get();
    }
    public static function getLastStatus($id_service)
    {
        return self::with('service')
            ->where('id_service', $id_service)
            ->orderBy('id', 'desc')->first();
    }
}
