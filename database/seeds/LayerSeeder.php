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
        factory(Layer::class)->create(['name' => 'Kafe'])
            ->addMedia(__DIR__ . '/icons/cafe.png')
            ->preservingOriginal()
            ->toMediaCollection(config('media.collections.icons'));

        factory(Layer::class)->create(['name' => 'Mall'])
            ->addMedia(__DIR__ . '/icons/mall.png')
            ->preservingOriginal()
            ->toMediaCollection(config('media.collections.icons'));

        factory(Layer::class)->create(['name' => 'Toko'])
            ->addMedia(__DIR__ . '/icons/shop.png')
            ->preservingOriginal()
            ->toMediaCollection(config('media.collections.icons'));

        factory(Layer::class)->create(['name' => 'Taman'])
            ->addMedia(__DIR__ . '/icons/tree.png')
            ->preservingOriginal()
            ->toMediaCollection(config('media.collections.icons'));
    }
}
