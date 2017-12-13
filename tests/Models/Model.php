<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Simoja\Laramin\Models\Role;

class Model extends TestCase
{
    use DatabaseMigrations;

    protected $slug= 'post';
    protected $prefix = 'admin';

    public function addModel()
    {
        $this->post("{$this->prefix}/{$this->slug}/post",[

        ]);
    }

    public function superAdministratorRole() {
        $role = factory(Role::class)->make([

        ]);
        return $role;
    }

    public function user_with_permission() {
        $user = factory(\App\User::class)->make();
        $user->attachRole('administrator');
        return $user;
    }

    public function user_without_permission() {
        $user = factory(\App\User::class)->make();
        $user->attachRole('user');
        return $user;
    }

    /** @test */
    public function it_can_see_a_create_form() {
        $response = $this->signIn($this->user_with_permission())->get(route("{$this->prefix}.{$this->slug}.create"));
        $response->assertSee(ucfirst($this->slug));
    }

    /** @test */
    public function it_can_add_a_model()
    {

    }
}
