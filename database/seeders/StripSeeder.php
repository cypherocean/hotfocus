<?php

    namespace Database\Seeders;
    use App\Models\Strip;

    use Illuminate\Database\Seeder;

    class StripSeeder extends Seeder{
        public function run(){
            for($i=1; $i<=5; $i++){
                Strip::create([
                    'name' => "Light $i",
                    'quantity' => 0,
                    'unit' => 5 * $i,
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
