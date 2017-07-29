<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{
    /** @test */
    public function a_user_may_register_but_has_to_confirm_his_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('first_name', 'John')
                    ->type('last_name', 'Doe')
                    ->type('email', 'johndoe@gmail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->check('terms')
                    ->press('Get Started');

            $browser->assertSee('Please confirm your email');
        });
    }
}
