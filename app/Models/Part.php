<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    public function serviceParts()
    {
        return $this->hasMany(ServicePart::class, 'id_part');
    }
}
