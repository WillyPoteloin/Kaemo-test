<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating some test data in Videos table using Video factory
        factory(App\Video::class, 30)->create();
    }
}
