<?php

    namespace Database\Seeders;
    use App\Models\Strip;

    use Illuminate\Database\Seeder;

    class StripSeeder extends Seeder{
        public function run(){
            $unit = array('inch' ,'feet' ,'meter');
            for($i=1; $i<=5; $i++){
                shuffle($unit);
                $unit_key = array_rand($unit,1);
                Strip::create([
                    'name' => "Light $i",
                    'quantity' => 0,
                    'unit' => $unit[$unit_key],
                    'choke' => "Light_$i",
                    'price' => 5 * $i,
                    'note' => "lorem ipsum $i",
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => 1
                ]);
            }
        }
    }
