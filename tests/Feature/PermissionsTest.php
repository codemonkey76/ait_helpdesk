<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    private User $agentUser;
    private User $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);

        $this->adminUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'admin', 'agent', 'user', 'restricted user'
        ]);

        $this->agentUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'agent', 'manager', 'user', 'restricted user'
        ]);
    }

    public function test_admin_can_render_permissions_page()
    {
        $this->actingAs($this->adminUser)
            ->get(route('permissions.index'))
            ->assertStatus(200);
    }

    public function test_non_admin_cannot_render_permissions_page()
    {
        $this->actingAs($this->agentUser)
            ->get(route('permissions.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_edit_permission()
    {
        $permission = Permission::factory()->create();
        $this->actingAs($this->adminUser)
            ->get(route('permissions.edit', $permission->id))
            ->assertStatus(200);

        $this->patch(route('permissions.update', $permission->id), [
            'name' => 'new name'
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('permissions.index'));
        $this->assertDatabaseHas('permissions', [
            'id'   => $permission->id,
            'name' => 'new name'
        ]);
    }

    public function test_non_admin_cannot_edit_permission()
    {
        $permission = Permission::factory()->create();

        $this->actingAs($this->agentUser)
            ->get(route('permissions.edit', $permission->id))
            ->assertStatus(403);

        $this->patch(route('permissions.update', $permission->id), [
            'name' => 'new name'
        ])
            ->assertStatus(403);
        $this->assertDatabaseMissing('permissions', [
            'id'   => $permission->id,
            'name' => 'new name'
        ]);
    }

    public function test_admin_can_create_new_permission()
    {
        $this->actingAs($this->adminUser)
            ->get(route('permissions.create'))
            ->assertStatus(200);

        $this->post(route('permissions.store'), [
            'name' => 'test permission'
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'test permission'
        ]);
    }

    public function test_non_admin_cannot_create_new_permission()
    {
        $this->actingAs($this->agentUser)
            ->get(route('permissions.index'))
            ->assertStatus(403);

        $this->post(route('permissions.store'), [
            'name' => 'new permission'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('permissions', [
            'name' => 'new permission'
        ]);
    }

    public function test_admin_can_delete_permission()
    {
        $permission = Permission::factory()->create();
        $this->actingAs($this->adminUser)
            ->delete(route('permissions.destroy', $permission->id))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('permissions.index'));

        $this->assertDatabaseMissing('permissions', [
            'id'   => $permission->id,
            'name' => $permission->name
        ]);
    }

    public function test_non_admin_cannot_delete_permission()
    {
        $permission = Permission::factory()->create();
        $this->actingAs($this->agentUser)
            ->delete(route('permissions.destroy', $permission->id))
            ->assertStatus(403);

        $this->assertDatabaseHas('permissions', [
            'id'   => $permission->id,
            'name' => $permission->name
        ]);
    }

    public function test_admin_can_render_roles_page()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->adminUser)
            ->get(route('roles.index'))
            ->assertStatus(200);
    }

    public function test_non_admin_cannot_render_roles_page()
    {
        $this->actingAs($this->agentUser)
            ->get(route('roles.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_create_role()
    {
        $this->actingAs($this->adminUser)
            ->get(route('roles.create'))
            ->assertStatus(200);

        $this->post(route('roles.store'), [
            'name' => 'new role'
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'new role'
        ]);
    }

    public function test_non_admin_cannot_create_role()
    {
        $this->actingAs($this->agentUser)
            ->get(route('roles.create'))
            ->assertStatus(403);

        $this->post(route('roles.store'), [
            'name' => 'new role'
        ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('roles', [
            'name' => 'new role'
        ]);
    }

    public function test_admin_can_edit_and_assign_permission_to_role()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        $this->actingAs($this->adminUser)
            ->get(route('roles.edit', $role->id))
            ->assertStatus(200);

        $this->patch(route('roles.update', $role->id), [
            'name' => 'new role'
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'id'   => $role->id,
            'name' => 'new role'
        ]);

        $this->post(route('roles.permissions.store', $role->id),
            [
                'permission_id' => $permission->id
            ])->assertSessionHasNoErrors()
            ->assertRedirect(route('roles.edit', $role->id));

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id'       => $role->id
        ]);
    }

    public function test_non_admin_cannot_edit_or_assign_permission_to_role()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        $this->actingAs($this->agentUser)
            ->get(route('roles.edit', $role->id))
            ->assertStatus(403);

        $this->patch(route('roles.update', $role->id), [
            'name' => 'new role'
        ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('roles', [
            'id'   => $role->id,
            'name' => 'new role'
        ]);

        $this->post(route('roles.permissions.store', $role->id),
            [
                'permission_id' => $permission->id
            ])->assertStatus(403);

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id'       => $role->id
        ]);
    }

    public function test_admin_can_remove_permission_from_role()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        $role->permissions()->syncWithoutDetaching($permission->id);

        $this->actingAs($this->adminUser)
            ->delete(route('roles.permissions.destroy', $role->id),
                [
                    'permission_id' => $permission->id
                ])->assertSessionHasNoErrors()
            ->assertRedirect(route('roles.edit', $role->id));

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id'       => $role->id
        ]);
    }

    public function test_non_admin_cannot_remove_permission_from_role()
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        $role->permissions()->syncWithoutDetaching($permission->id);

        $this->actingAs($this->agentUser)
            ->delete(route('roles.permissions.destroy', $role->id),
                [
                    'permission_id' => $permission->id
                ])->assertStatus(403);

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id'       => $role->id
        ]);
    }
}
