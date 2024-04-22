<?php

namespace Core\Auth\Providers;

use App\Models\User;
use Core\Auth\Enums\UserRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthService
{

    public function __construct()
    {
        // check if the roles and permissions have been seeded
        if (Role::count() === 0) {
            $this->seedRoles();
        }
    }

    public function createUser(UserRole $role, array $data): User
    {
        return match ($role) {
            UserRole::ADMINISTRATOR => $this->createAdmin($data),
            UserRole::CASHIER => $this->createCashier($data),
            UserRole::INVENTORY_MANAGER => $this->createInventoryManager($data),
        };
    }

    // createAdmin
    private function createAdmin(array $data): User
    {
        $user = User::factory()->create($data);
        $user->assignRole(UserRole::ADMINISTRATOR);
        return $user;
    }

    // createCashier
    private function createCashier(array $data): User
    {
        $user = User::factory()->create($data);
        $user->assignRole(UserRole::CASHIER);
        return $user;
    }

    // createInventoryManager
    private function createInventoryManager(array $data): User
    {
        $user = User::factory()->create($data);
        $user->assignRole(UserRole::INVENTORY_MANAGER);
        return $user;
    }

    public function seedRoles(): void
    {
        $roles = UserRole::cases();
        foreach ($roles as $role) {
            $role = Role::firstOrCreate(['name' => $role->value]);
        }

        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage products']);
        Permission::firstOrCreate(['name' => 'manage sales']);
        Permission::firstOrCreate(['name' => 'manage inventory']);

        // Assign all permissions to the administrator role
        $administratorRole = Role::findByName(UserRole::ADMINISTRATOR->value);
        $administratorRole->syncPermissions([
            'manage users',
            'manage products',
            'manage sales',
            'manage inventory',
        ]);

        Permission::firstOrCreate(['name' => 'process sales']);
        Permission::firstOrCreate(['name' => 'manage orders']);
        Permission::firstOrCreate(['name' => 'view sales reports']);

        // Assign permissions to the cashier role
        $cashierRole = Role::findByName(UserRole::CASHIER->value);
        $cashierRole->syncPermissions([
            'process sales',
            'manage orders',
            'view sales reports',
        ]);

        Permission::firstOrCreate(['name' => 'manage inventory']);
        Permission::firstOrCreate(['name' => 'generate inventory reports']);

        // Assign permissions to the inventory manager role
        $inventoryManagerRole = Role::findByName(UserRole::INVENTORY_MANAGER->value);
        $inventoryManagerRole->syncPermissions([
            'manage inventory',
            'generate inventory reports',
        ]);
    }

}
