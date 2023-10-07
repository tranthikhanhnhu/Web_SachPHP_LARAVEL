<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductInCategory;
use App\Models\RentPrice;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for($i = 0; $i < 100; $i++) {
            $id = DB::table('users')->insertGetId([
                'username' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
                'level' => rand(0,1),
                'status' => rand(0,1),
                'phone_number' => rand(100000000, 9999999999),
                'created_at' => Carbon::now(),
            ]);
            DB::table('users_info')->insert([
                'user_id' => $id,
                'last_name' => Str::random(6),
                'first_name' => Str::random(6),
                'gender' => rand(0,1),
                'dob' => Carbon::today()->subDays(rand(0, 180)),
                'created_at' => Carbon::now(),
            ]);
              DB::table('categories')->insert([
                'name' => Str::random(10),
                'slug' => Str::random(12),
                'status' => rand(0,1),
                'image_url' => 'aaa',
                'created_at' => Carbon::now(),
            ]);

            $product = Product::create([
                'name' => Str::random(10),
                'slug' => Str::random(10),
                'description' => Str::random(200),
                'short_description' => Str::random(50),
                'status' => 1,
                'price' => rand(10000, 20000),
                'created_at' => Carbon::now(),
                'book_layout' => rand(0, 1),
                'author' => Str::random(10),
                'publisher_id' => 1,
                'origin_id' => 1,
                'height' => rand(90, 100),
                'width' => rand(90, 100),
                'weight' => rand(90, 100),
                'thickness' => rand(90, 100),
                'number_of_pages' => rand(90, 100),
                'publish_year' => rand(2020, 2023),
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'created_at' => Carbon::now(),
                'image_url' => '2020_12_17_16_50_30_12-390x510_1691504141.jpg',
                'type' => 1
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'created_at' => Carbon::now(),
                'image_url' => '2020_12_17_16_50_30_1-390x510_1691504141.jpg',
                'type' => 2
            ]);
            ProductInCategory::create([
'product_id' => $product->id,
                'category_id' => rand(1, 2),
            ]);
            RentPrice::create([
                'created_at' => Carbon::now(),
                'product_id' => $product->id,
                'price' => rand(200, 10000),
                'number_of_days' => 1,
            ]);
            RentPrice::create([
                'created_at' => Carbon::now(),
                'product_id' => $product->id,
                'price' => rand(200, 10000),
                'number_of_days' => 7,
            ]);
            RentPrice::create([
                'created_at' => Carbon::now(),
                'product_id' => $product->id,
                'price' => rand(200, 10000),
                'number_of_days' => 30,
            ]);
            RentPrice::create([
                'created_at' => Carbon::now(),
                'product_id' => $product->id,
                'price' => rand(200, 10000),
                'number_of_days' => 90,
            ]);
          
        }



        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}