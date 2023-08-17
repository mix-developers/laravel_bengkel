<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartStok extends Model
{
    use HasFactory;


    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class, 'id_part', 'id');
    }

    public static function getStok($id)
    {
        return self::with('part')->where('id_part', $id);
    }
}
