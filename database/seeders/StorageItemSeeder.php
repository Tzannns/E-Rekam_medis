<?php

namespace Database\Seeders;

use App\Models\StorageItem;
use Illuminate\Database\Seeder;

class StorageItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StorageItem::factory(50)->create();
    }
}
