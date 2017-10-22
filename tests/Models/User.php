<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Simoja\Laramin\Facades\Laramin;

class User extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function add_and_remove_role_from_user()
    {
        $this->signIn();
        $this->user->attachRole('superadministrator');
        $this->assertTrue($this->user->hasRole('superadministrator'));

        $this->user->detachRole('superadministrator');
        $this->assertFalse($this->user->hasRole('superadministrator'));
    }

    /** @test */
    public function user_already_logged_in()
    {
        $response = $this->signIn()->get(route('laramin.login'));
        $response2 = $this->get(route('laramin.dashboard'));
        $response->assertStatus(302);
        $response2->assertStatus(200);
    }

    public function it_add_an_user_response()
    {
        return $this->signIn($this->user)->json('POST', '/api/admin/addUser', [
            'name' => 'John',
            'email' => 'email@email.com',
            'role' => 'administrator',
            'auth_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_has_permission_to_add_user()
    {
        $this->user = factory(\App\User::class)->create();
        $this->user->attachRole('administrator');
        $response = $this->it_add_an_user_response();
        $user = Laramin::model('User')->where('email','email@email.com')->first();
        $response
            ->assertStatus(200);
        $this->assertTrue($user->hasRole('administrator'));
    }

    /** @test */
    public function it_has_not_permission_to_add_user()
    {
        $this->user = factory(\App\User::class)->create();
        $this->user->attachRole('user');
        $response = $this->it_add_an_user_response();
        $response->assertStatus(404);
    }

    public function it_update_an_user_response($user)
    {
        return $this->signIn($this->user)->json('PUT', '/api/admin/editUser',[
        'id' => $user->id,
        'name' => 'NameChanged',
        'email' => 'EmailChange@email.com',
        'role' => 'user',
        'auth_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_has_permission_to_update_an_user()
    {
        $this->user = factory(\App\User::class)->create();
        $this->user->attachRole('administrator');
        $this->assertTrue($this->user->can('update-users'));

        $user = factory(\App\User::class)->create();
        $user->attachRole('administrator');

        $response = $this->it_update_an_user_response($user);

        $response->assertStatus(200);

        $this->assertFalse($user->name == 'NameChanged');
        $this->assertFalse($user->email == 'EmailChange@email.com');

        $this->assertFalse($user->hasRole('administrator'));
        $this->assertTrue($user->hasRole('user'));

        $user = Laramin::model('User')::find($user->id);
        $this->assertTrue($user->name == 'NameChanged');
        $this->assertTrue($user->email == 'EmailChange@email.com');
    }

    /** @test */
    public function it_has_not_the_permission_to_update_an_user()
    {
        $this->user = factory(\App\User::class)->create();
        $this->user->attachRole('user');
        $this->assertFalse($this->user->can('update-users'));

        $user = factory(\App\User::class)->create();
        $user->attachRole('administrator');

        $response = $this->it_update_an_user_response($user);

        $response->assertStatus(404);

        $this->assertFalse($user->name == 'NameChanged');
        $this->assertFalse($user->email == 'EmailChange@email.com');

        $this->assertTrue($user->hasRole('administrator'));
        $this->assertFalse($user->hasRole('user'));

        $user = Laramin::model('User')::find($user->id);
        $this->assertTrue($user->name !== 'NameChanged');
        $this->assertTrue($user->email !== 'EmailChange@email.com');
    }

    public function it_destroy_an_user_response($user)
    {
        return $this->signIn($this->user)->json('DELETE', '/api/admin/deleteUser/'.$this->user->id.'/'.$user->id);
    }

    /** @test */
    public function it_has_permission_to_destroy_an_user()
    {
          $this->user = factory(\App\User::class)->create();
          $this->user->attachRole('administrator');

          $user = factory(\App\User::class)->create();
          $count = Laramin::model('User')->all()->count();

          $response = $this->it_destroy_an_user_response($user);

          $response->assertStatus(200)
                   ->assertExactJson([
                    'destroyed' => true,
                    ]);

          $this->assertEquals(Laramin::model('User')->all()->count(),$count-1);
    }

     /** @test */
    public function it_has_not_permission_to_destroy_an_user()
    {
          $this->user = factory(\App\User::class)->create();
          $this->user->attachRole('user');

          $user = factory(\App\User::class)->create();
          $count = Laramin::model('User')->all()->count();

          $response = $this->it_destroy_an_user_response($user);

          $response->assertStatus(404);

          $this->assertEquals(Laramin::model('User')->all()->count(),$count);
    }
}
