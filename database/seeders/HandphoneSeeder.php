<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Handphone;

class HandphoneSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Data yang akan di-loop sebanyak 100 kali
        foreach (range(1, 100) as $index) {
            Handphone::create([
                'imei' => $faker->unique()->numerify('###############'), // Membuat IMEI yang unik
                'model' => $this->getRandomSamsungModel(), // Mendapatkan model handphone Samsung acak
                'ukuran_layar' => $faker->randomFloat(2, 4.0, 7.0), // Ukuran layar random antara 4.0 hingga 7.0 inci
                'id_ram' => $faker->randomElement([1, 2, 3, 4, 5, 6]), // ID RAM acak
                'id_tipe_handphone' => $faker->randomElement([1, 2, 3]), // ID tipe handphone acak
                'id_status' => 100, // ID status acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Fungsi untuk mendapatkan model Samsung secara acak
    private function getRandomSamsungModel()
    {
        $models = [
            'Samsung Galaxy S21',
            'Samsung Galaxy A52',
            'Samsung Galaxy Note 20',
            'Samsung Galaxy S20 FE',
            'Samsung Galaxy A72',
            'Samsung Galaxy Z Fold 3',
            'Samsung Galaxy Z Flip 3',
            'Samsung Galaxy A32',
            'Samsung Galaxy M32',
            'Samsung Galaxy S21 Ultra',
            'Samsung Galaxy A12',
            'Samsung Galaxy M51',
            'Samsung Galaxy A02',
            'Samsung Galaxy A21s',
            'Samsung Galaxy Note 10',
        ];

        return $models[array_rand($models)]; // Mengembalikan model acak dari array
    }
}
