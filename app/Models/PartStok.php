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
    public static function getPemasukan($id)
    {
        return self::with('part')->where('id_part', $id)->where('type', 1);
    }
    public static function getPengeluaran($id)
    {
        return self::with('part')->where('id_part', $id)->where('type', 0);
    }
    public static function getStok($id)
    {
        $pemasukan = self::getPemasukan($id)->sum('stok');
        $pengeluaran = self::getPengeluaran($id)->sum('stok');
        return $pemasukan - $pengeluaran;
    }
}
