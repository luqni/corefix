<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePartType extends Model
{
    protected $fillable = ['name', 'slug'];

    public function spareParts()
    {
        return $this->hasMany(SparePart::class);
    }
}
