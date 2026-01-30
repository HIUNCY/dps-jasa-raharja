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
        // Adjust the path to where the SQL file is located relative to the laravel project root
        // The project root is dps-jasa-raharja. The file is in ../insurance_master_data.sql
        $path = base_path('../insurance_master_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);
            $this->command->info('Master data seeded successfully from SQL file.');
        } else {
            $this->command->error('SQL file not found at: ' . $path);
        }
    }
}
