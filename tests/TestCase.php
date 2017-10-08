<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    protected function signIn($user = null)
    {
        if($user == null)
        {
            $this->user = factory(\App\User::class)->create();
        }else {
            $this->user = $user;
        }
        return $this->actingAs($this->user);
    }
}
