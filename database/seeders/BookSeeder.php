<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::create(['image' => 'poto1.png', 'title' => 'apapun', 'description' => 'test aja', 'author' => 'refdi', 'price' => 36000]);
        Book::create(['image' => 'poto2.png', 'title' => 'apapun2', 'description' => 'test aja2', 'author' => 'refdi2', 'price' => 76000]);
    }
}
