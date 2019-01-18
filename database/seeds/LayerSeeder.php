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
        factory(Layer::class)->create(['name' => 'Kafe']);
        factory(Layer::class)->create(['name' => 'Ruko']);
        factory(Layer::class)->create(['name' => 'Toko']);
        factory(Layer::class)->create(['name' => 'Minimarket']);
    }
}
