<?php

use Illuminate\Database\Seeder;
use App\ProductStatus;

class ProductStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductStatus::truncate();

        ProductStatus::create(['description' => 'Oanvänd']);
        ProductStatus::create(['description' => 'Använd för visning (aldrig inkopplad)']);
        ProductStatus::create(['description' => 'Använd i bänk (inkopplad)']);
        ProductStatus::create(['description' => 'Använd i anläggning (inkopplad)']);
    }
}
