<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => 'Pemrograman Laravel Dasar',
                'author' => 'Dewi Aulia',
                'publisher' => 'Informatika Press',
                'year' => 2022,
                'category' => 'Teknologi',
                'stock' => 10,
                'max_loan_days' => 7,
                'daily_fine' => 2000,
            ],
            [
                'title' => 'Algoritma & Struktur Data',
                'author' => 'Hadi Wibowo',
                'publisher' => 'Graha Ilmu',
                'year' => 2021,
                'category' => 'Komputer',
                'stock' => 5,
                'max_loan_days' => 5,
                'daily_fine' => 1500,
            ],
            [
                'title' => 'Hukum Keluarga Islam Modern',
                'author' => 'Dr. Fathur',
                'publisher' => 'Sinar Grafika',
                'year' => 2020,
                'category' => 'Hukum',
                'stock' => 4,
                'max_loan_days' => 10,
                'daily_fine' => 1000,
            ],
        ];

        foreach ($books as $data) {
            Book::create($data);
        }
    }
}
