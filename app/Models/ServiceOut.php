<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOut extends Model
{
    use HasFactory;
    public static function getIdentity($code)
    {
        return self::where('code', $code)->first();
    }
}
