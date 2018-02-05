<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $prefix = 'admin';

    protected function create($namespace, $param = [])
    {
        return factory($namespace)->create($param);
    }

    protected function signIn($user = null)
    {
        $user ?: $this->create("\App\User");

        return $this->actingAs($user);
    }
}
