<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->value('username', 'admin')
                ->value('password', 'admin')
                ->click('button[type=submit]')
                ->assertPathIs('/layer/index');
        });
    }
}
