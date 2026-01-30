<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // The file is now inside database/sql/insurance_master_data.sql
        $path = database_path('sql/insurance_master_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);
            $this->command->info('Master data seeded successfully from SQL file.');
        } else {
            $this->command->error('SQL file not found at: ' . $path);
        }
    }
}
