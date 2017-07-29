<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_may_register_but_must_verify_their_email()
    {
        $user = factory('App\User')->create();
    }
}
