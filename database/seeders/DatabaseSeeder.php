<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Debit;
use App\Models\Employee;
use App\Models\EmployeStatus;
use App\Models\Position;
use App\Models\Source;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(30)->create();
        Category::factory()->count(5)->create();
        Debit::factory()->count(200)->create();
        Source::factory()->count(5)->create();
        // Employee::factory()->count(30)->create();

        Position::create([
            'name' => 'Project Manager',
            'level' => 'Senior',
        ]);
        Position::create([
            'name' => 'Web Developer',
            'level' => 'Senior',
        ]);
        Position::create([
            'name' => 'Web Developer',
            'level' => 'Junior',
        ]);
        Position::create([
            'name' => 'UI/UX Designer',
            'level' => 'Senior',
        ]);
        Position::create([
            'name' => 'Mobile Developer',
            'level' => 'Senior',
        ]);

        User::create([
            'name' => 'demo',
            'email' => 'demo@weza.co.id',
            'password' => bcrypt('password'),
        ]);

        Employee::create([
            'nip' => 'WZ001',
            'nik' => '1234567890',
            'name' => 'Muhammad Nafi Udin',
            'email' => 'muhammadnafiudin@weza.co.id',
            'whatsapp_number' => '6281234567890',
            'address' => 'Sedati, Sidoarjo',
            'position_id' => 1,
            'no_bpjstk' => '778239834221',
            'no_npwp' => '221234567890000',
            'bank_account' => '00228473298742',
            'bank_code' => '002',
            'employe_status_id' => 1,
            'salary' => 5000000,
        ]);
        Employee::create([
            'nip' => 'WZ002',
            'nik' => '12345678933',
            'name' => 'Fahril Refiandi',
            'email' => 'fahrilrefiandi@weza.co.id',
            'whatsapp_number' => '6282131371687',
            'address' => 'Jl Kawi 7 , Blitar',
            'position_id' => 3,
            'no_bpjstk' => '990087667362',
            'no_npwp' => '009378263782000',
            'bank_account' => '0024432987432',
            'bank_code' => '002',
            'employe_status_id' => 2,
            'salary' => 3000000,
        ]);

        EmployeStatus::create([
          "name" => "PKWTT",
          "start_date" => $start=Carbon::now()->format('Y-m-d'),
          "end_date" => $end=Carbon::now()->addDays(365)->format('Y-m-d'),
          "duration" => Carbon::parse($end)->diffInDays(Carbon::parse($start)),
        ]);
        EmployeStatus::create([
          "name" => "PKWTT",
          "start_date" => $start=Carbon::now()->format('Y-m-d'),
          "end_date" => $end=Carbon::now()->addDays(365)->format('Y-m-d'),
          "duration" => Carbon::parse($end)->diffInDays(Carbon::parse($start)),
        ]);
    }
}
