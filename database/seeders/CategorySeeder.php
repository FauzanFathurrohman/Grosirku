<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Sembako', 'Minuman', 'Makanan Ringan', 'Kesehatan', 'Kecantikan', 'Kebersihan'];

        foreach ($categories as $name) {
            Category::firstOrcreate(['name' => $name]);
        }
    }
}
