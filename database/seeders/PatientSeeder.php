<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Patient::insert([
            ['nama'=>'Budi','alamat'=>'Bandung','no_telp'=>'0811222333','hospital_id'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['nama'=>'Ani','alamat'=>'Jakarta','no_telp'=>'0811222444','hospital_id'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['nama'=>'Joko','alamat'=>'Bali','no_telp'=>'0811222555','hospital_id'=>2,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
