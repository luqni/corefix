<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SparePartType;
use App\Models\SparePart;
use Illuminate\Support\Str;

class SparePartTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['LCD', 'Battery', 'Speaker', 'Charging Port', 'Camera', 'Back Glass', 'Service', 'Other'];

        foreach ($types as $typeName) {
            SparePartType::updateOrCreate(
                ['slug' => Str::slug($typeName)],
                ['name' => $typeName]
            );
        }

        // Backfill existing parts
        $parts = SparePart::whereNull('spare_part_type_id')->get();
        foreach ($parts as $part) {
            // Try to find a matching type by name
            $type = SparePartType::where('name', $part->type)->first();
            if ($type) {
                $part->update(['spare_part_type_id' => $type->id]);
            } else {
                // If no exact match, assign to 'Other' or create new type? 
                // Let's create a new type based on the string if it's not empty
                if (!empty($part->type)) {
                     $newType = SparePartType::firstOrCreate(
                        ['slug' => Str::slug($part->type)],
                        ['name' => $part->type]
                    );
                    $part->update(['spare_part_type_id' => $newType->id]);
                }
            }
        }
    }
}
