<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    public function test_home_page_can_be_rendered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Business Support');
        });
    }
}
