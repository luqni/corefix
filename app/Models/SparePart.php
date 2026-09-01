<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = ['code', 'name', 'type', 'spare_part_type_id', 'capital_price', 'price', 'stock'];

    protected static function booted()
    {
        static::created(function ($part) {
            if (empty($part->code)) {
                $part->updateQuietly([
                    'code' => 'SP-' . str_pad($part->id, 4, '0', STR_PAD_LEFT),
                ]);
            }
        });
    }

    public function type()
    {
        return $this->belongsTo(SparePartType::class, 'spare_part_type_id');
    }

    public function getItemCodeAttribute(): string
    {
        return $this->code ?: ('SP-' . str_pad($this->id, 4, '0', STR_PAD_LEFT));
    }

    public static function findByCodeOrId(?string $identifier): ?self
    {
        if (!$identifier) {
            return null;
        }

        $identifier = trim($identifier);

        // Check if QR code contains prefix COREFIX:PART:{id or code}
        if (str_starts_with($identifier, 'COREFIX:PART:')) {
            $identifier = substr($identifier, 13);
        }

        // Try exact code match (case insensitive)
        $part = static::whereRaw('LOWER(code) = ?', [strtolower($identifier)])->first();
        if ($part) {
            return $part;
        }

        // Try exact numeric ID match
        if (is_numeric($identifier)) {
            $part = static::find((int) $identifier);
            if ($part) {
                return $part;
            }
        }

        // Try stripping SP- or SPP- prefix for numeric ID
        if (preg_match('/^SP-?0*(\d+)$/i', $identifier, $matches)) {
            $part = static::find((int) $matches[1]);
            if ($part) {
                return $part;
            }
        }

        // Fallback by exact name match
        return static::whereRaw('LOWER(name) = ?', [strtolower($identifier)])->first();
    }
}
