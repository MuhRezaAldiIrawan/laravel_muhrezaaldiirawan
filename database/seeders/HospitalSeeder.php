<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Hospital::insert([
            ['name'=>'RS Sentot','address'=>'Bandung','email'=>'sentot@rs.test','phone'=>'0811000001','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'RS Ali','address'=>'Jakarta','email'=>'ali@rs.test','phone'=>'0811000002','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'RS Mahmud','address'=>'Bali','email'=>'mahmud@rs.test','phone'=>'0811000003','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
