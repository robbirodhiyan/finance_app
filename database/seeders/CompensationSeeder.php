<?php

namespace Database\Seeders;

use App\Models\Compensation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompensationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Compensation::create([
          'code' => "WZC0001",
          'name' => "Uang Makan",
          'amount' => 300000,
          'amount_type' => "fixed",
          'compensation_type' => "allowance",
          'apply_date' => now()->format('Y-m-d'),
        ]);

        Compensation::create([
          'code' => "WZC0001",
          'name' => "Pembayaran BPJSK ditanggung perusahaan",
          'amount' => 4,
          'amount_type' => "percentage",
          'compensation_type' => "deduction",
          'apply_date' => now()->format('Y-m-d'),
        ]);

        Compensation::create([
          'code' => "WZC0001",
          'name' => "Pembayaran BPJSK ditanggung pribadi",
          'amount' => 1,
          'amount_type' => "percentage",
          'compensation_type' => "deduction",
          'apply_date' => now()->format('Y-m-d'),
        ]);

        Compensation::create([
          'code' => "WZC0001",
          'name' => "PPN",
          'amount' => 5,
          'amount_type' => "percentage",
          'compensation_type' => "deduction",
          'apply_date' => now()->format('Y-m-d'),
        ]);
    }
}
