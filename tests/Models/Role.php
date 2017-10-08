<?php

namespace Simoja\Laramin\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Simoja\Laramin\Facades\Laramin;
use Simoja\Laramin\Models\Role as RoleModel;

class Role extends TestCase
{
    use DatabaseTransactions;

        public function adding_role_api()
        {
             return $this->signIn($this->user)->json('POST', '/api/admin/addRole', [
                'name' => 'Semiadmin',
                'display_name' => 'semiadmin',
                'description' => 'is a semi admin'
                ]);
        }
        public function editing_role_api()
        {
             return $this->signIn($this->user)->json('PUT', '/api/admin/editRole', [
                'name' => 'Semiadminedited',
                'display_name' => 'semiadminedited',
                'description' => 'is a semi admin'
                ]);
        }
        /** @test */
        public function it_can_add_a_role()
        {
            $this->signIn();
            $this->user->attachRole('administrator');
            $count = Laramin::model('Role')->count();
            $this->assertTrue($this->user->can('create-roles'));
            $response = $this->adding_role_api();
            $response->assertStatus(200);
            $this->assertEquals($count + 1,Laramin::model('Role')->count());
        }
         /** @test */
        public function it_can_not_add_a_role()
        {
            $this->signIn();
            $this->user->attachRole('user');
            $count = Laramin::model('Role')->count();
            $this->assertFalse($this->user->can('create-roles'));
            $response = $this->adding_role_api();
            $response->assertStatus(404);
            $this->assertEquals($count,Laramin::model('Role')->count());
        }
        // /** @test */
        // public function it_can_edit_a_role()
        // {
        //     $this->signIn();
        //     $this->user->attachRole('administrator');
        //     $role = Laramin::model('Role')->create([
        //         'name' => 'Semiadmin',
        //         'display_name' => 'semiadmin',
        //         'description' => 'is a semi admin'
        //         ]);
        // }

}
