<?php

namespace Database\Seeders;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('personal_records')->truncate();
        DB::table('movements')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::insert([
            ['id' => 1, 'name' => 'Joao', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Jose', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Paulo', 'created_at' => now(), 'updated_at' => now()]
        ]);

        Movement::insert([
            ['id' => 1, 'name' => 'Deadlift', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Back Squat', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Bench Press', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $now = now();
        DB::table('personal_records')->insert([
            ['user_id' => 1, 'movement_id' => 1, 'value' => 100.0, 'date' => '2021-01-01 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'movement_id' => 1, 'value' => 180.0, 'date' => '2021-01-02 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'movement_id' => 1, 'value' => 150.0, 'date' => '2021-01-03 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'movement_id' => 1, 'value' => 110.0, 'date' => '2021-01-04 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'movement_id' => 1, 'value' => 110.0, 'date' => '2021-01-04 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'movement_id' => 1, 'value' => 140.0, 'date' => '2021-01-05 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'movement_id' => 1, 'value' => 190.0, 'date' => '2021-01-06 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 3, 'movement_id' => 1, 'value' => 170.0, 'date' => '2021-01-01 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 3, 'movement_id' => 1, 'value' => 120.0, 'date' => '2021-01-02 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 3, 'movement_id' => 1, 'value' => 130.0, 'date' => '2021-01-03 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'movement_id' => 2, 'value' => 130.0, 'date' => '2021-01-03 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'movement_id' => 2, 'value' => 130.0, 'date' => '2021-01-03 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 3, 'movement_id' => 2, 'value' => 125.0, 'date' => '2021-01-03 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'movement_id' => 2, 'value' => 110.0, 'date' => '2021-01-05 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'movement_id' => 2, 'value' => 100.0, 'date' => '2021-01-01 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'movement_id' => 2, 'value' => 120.0, 'date' => '2021-01-01 00:00:00', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 3, 'movement_id' => 2, 'value' => 120.0, 'date' => '2021-01-01 00:00:00', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
