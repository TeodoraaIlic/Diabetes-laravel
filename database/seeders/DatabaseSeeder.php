<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call(IngredientSeeder::class);
        $this->call(RecipeSeeder::class);

        $standardUserRole = Role::create(['name' => 'standard']);
        $premiumUserRole = Role::create(['name' => 'premium']);
        $adminUserRole = Role::create(['name' => 'admin']);

        // Create permissions
        $permissionPremium = Permission::create(['name' => 'premium user']);
        $permissionStandard = Permission::create(['name' => 'standard user']);
        $permissionAdmin = Permission::create(['name' => 'admin user']);

        // Assign permissions to roles
        $standardUserRole->givePermissionTo($permissionStandard);
        $premiumUserRole->givePermissionTo([$permissionPremium, $permissionStandard]);
        $adminUserRole->givePermissionTo([$permissionAdmin, $permissionPremium, $permissionStandard]);
    }
}
