<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('laundry')) {
            $hasNamaItem = Schema::hasColumn('laundry', 'nama_item');
            $hasItem = Schema::hasColumn('laundry', 'item');

            if ($hasNamaItem && $hasItem) {
                DB::statement('UPDATE `laundry` SET `item` = COALESCE(`item`, `nama_item`) WHERE `nama_item` IS NOT NULL');
                DB::statement('ALTER TABLE `laundry` DROP COLUMN `nama_item`');
            } elseif ($hasNamaItem && ! $hasItem) {
                DB::statement('ALTER TABLE `laundry` CHANGE COLUMN `nama_item` `item` VARCHAR(255) NOT NULL');
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('laundry')) {
            $hasItem = Schema::hasColumn('laundry', 'item');
            $hasNamaItem = Schema::hasColumn('laundry', 'nama_item');

            if ($hasItem && ! $hasNamaItem) {
                DB::statement('ALTER TABLE `laundry` ADD COLUMN `nama_item` VARCHAR(255) NULL');
            }
        }
    }
};
