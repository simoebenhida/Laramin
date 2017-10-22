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
         return $this->signIn($this->user)->json('POST', "/api/{$this->prefix}/addRole", [
            'name' => 'Semiadmin',
            'display_name' => 'semiadmin',
            'description' => 'is a semi admin',
            'auth_id' => $this->user->id
            ]);
    }
    public function editing_role_api($id)
    {
         return $this->signIn($this->user)->json('PUT', "/api/{$this->prefix}/editRole", [
            'name' => 'Semiadminedited',
            'display_name' => 'semiadminedited',
            'description' => 'is a semi admin',
            'id' => $id,
            'auth_id' => $this->user->id
            ]);
    }
    public function deleting_role_api($id)
    {
         return $this->signIn($this->user)->json('DELETE', "/api/{$this->prefix}/deleteRole/{$this->user->id}/{$id}");
    }
    public function connecte_with_attaching_role($role)
    {
        $this->signIn();
        $this->user->attachRole($role);
    }
    /** @test */
    public function it_can_add_a_role()
    {
        $this->connecte_with_attaching_role('administrator');
        $count = Laramin::model('Role')->count();
        $this->assertTrue($this->user->can('create-roles'));
        $response = $this->adding_role_api();
        $response->assertStatus(200);
        $this->assertEquals($count + 1,Laramin::model('Role')->count());
    }
     /** @test */
    public function it_can_not_add_a_role()
    {
        $this->connecte_with_attaching_role('user');

        $count = Laramin::model('Role')->count();
        $this->assertFalse($this->user->can('create-roles'));
        $response = $this->adding_role_api();
        $response->assertStatus(404);
        $this->assertEquals($count,Laramin::model('Role')->count());
    }
    /** @test */
    public function it_can_edit_a_role()
    {
        $this->connecte_with_attaching_role('administrator');

        $role = Laramin::model('Role')->create([
            'name' => 'Semiadmin',
            'display_name' => 'semiadmin',
            'description' => 'is a semi admin'
            ]);
        $response = $this->editing_role_api($role->id);
        $response->assertStatus(200);
        $role = Laramin::model('Role')->find($role->id);
        $this->assertEquals($role->name,'Semiadminedited');
        $this->assertEquals($role->display_name,'semiadminedited');
    }
    /** @test */
    public function it_can_not_edit_a_role()
    {
        $this->connecte_with_attaching_role('user');

        $role = Laramin::model('Role')->create([
            'name' => 'Semiadmin',
            'display_name' => 'semiadmin',
            'description' => 'is a semi admin'
            ]);
        $response = $this->editing_role_api($role->id);
        $response->assertStatus(404);
        $role = Laramin::model('Role')->find($role->id);
        $this->assertNotEquals($role->name,'Semiadminedited');
        $this->assertNotEquals($role->display_name,'semiadminedited');
    }
    /** @test */
    public function it_can_delete_a_role()
    {
        $this->connecte_with_attaching_role('administrator');
        $role = Laramin::model('Role')->create([
            'name' => 'Semiadmin',
            'display_name' => 'semiadmin',
            'description' => 'is a semi admin'
            ]);
        $oldCount = Laramin::model('Role')->count();
        $response = $this->deleting_role_api($role->id);
        $response->assertStatus(200);
        $this->assertEquals($oldCount - 1,Laramin::model('Role')->count());
    }
    /** @test */
    public function it_can_not_delete_a_role()
    {
        $this->connecte_with_attaching_role('user');
        $role = Laramin::model('Role')->create([
            'name' => 'Semiadmin',
            'display_name' => 'semiadmin',
            'description' => 'is a semi admin'
            ]);
        $oldCount = Laramin::model('Role')->count();
        $response = $this->deleting_role_api($role->id);
        $response->assertStatus(404);
        $this->assertEquals($oldCount,Laramin::model('Role')->count());
    }
}
