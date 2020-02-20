<?php

namespace Tests\Feature;

use App\Layer;
use App\User;
use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanCreateLocation()
    {
        $adminUser = factory(User::class)->create();
        $layer = factory(Layer::class)->create();

        /** @var Location $location */
        $location = factory(Location::class)->make();

        $this->actingAs($adminUser)
            ->postJson(route("location.store"), [
                "name" => $location->name,
                "layer_id" => $layer->layer_id,
                "address" => $location->address,
                "description" => $location->description,
                "latitude" => $location->latitude,
                "longitude" => $location->longitude,
                "has_virtual_tour" => true,
            ])
            ->assertSessionHasNoErrors()
            ->assertStatus(200);
    }
}
