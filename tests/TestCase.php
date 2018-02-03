<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected $user;
    protected $prefix = 'admin';
    protected function signIn($user = null)
    {
        if ($user == null) {
            $this->user = factory(\App\User::class)->create();
        } else {
            $this->user = $user;
        }
        return $this->actingAs($this->user);
    }
}
