<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Simoja\Laramin\Facades\Laramin;

class ChangePassword extends TestCase
{
    use DatabaseMigrations;

    public function edit_password()
    {
        return $this->signIn($this->user)->json('PUT', '/api/admin/editOwnPassword', [
            'old_password' => 'password',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'auth_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_can_edit_a_password()
    {
          $this->user = factory(\App\User::class)->create();
          $response = $this->edit_password();
          $response->assertStatus(200);

          $this->assertFalse(Hash::check('password',Laramin::model('User')->find($this->user->id)->password));

          $this->assertTrue(Hash::check('secret',Laramin::model('User')->find($this->user->id)->password));
    }
}
