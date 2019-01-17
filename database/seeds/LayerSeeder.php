<?php

use Illuminate\Database\Seeder;
use App\Layer;

class LayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Layer::create(['name' => 'Kafe', 'description' => '']);
        Layer::create(['name' => 'Ruko', 'description' => '']);
        Layer::create(['name' => 'Toko', 'description' => '']);
        Layer::create(['name' => 'Minimarket', 'description' => '']);
    }
}
