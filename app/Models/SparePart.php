<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = ['name', 'type', 'spare_part_type_id', 'price', 'stock'];

    public function type()
    {
        return $this->belongsTo(SparePartType::class, 'spare_part_type_id');
    }
}
