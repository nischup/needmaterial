<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class ACLDataSeeder extends Seeder
{
    public $role;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Module::truncate();
        Permission::truncate();
        Role::truncate();

        $adminRole = Role::create(['name' =>  User::ADMIN_ROLE_NAME]);
        $user = User::whereEmail('admin@mail.com')->first();
        $user->assignRole($adminRole);

        $customerRole = Role::create(['name' => User::CUSTOMER_ROLE_NAME]);
        $user = User::whereEmail('customer@mail.com')->first();
        $user->assignRole($customerRole);

        $supplierRole = Role::create(['name' => User::SUPPLIER_ROLE_NAME]);
        $user = User::whereEmail('supplier@mail.com')->first();
        $user->assignRole($supplierRole);
        $user->assignRole($customerRole);

        $this->createAdminPermissions('Administrator - Users', [
            ['name' => 'create users'],
            ['name' => 'read users'],
            ['name' => 'update users'],
            ['name' => 'delete users'],
        ], $adminRole);

        $this->createAdminPermissions('Administrator - Roles', [
            ['name' => 'create roles'],
            ['name' => 'read roles'],
            ['name' => 'update roles'],
            ['name' => 'delete roles'],
        ], $adminRole);

        $this->createAdminPermissions('Administrator - Permissions', [
            ['name' => 'read permissions'],
            ['name' => 'update permissions'],
        ], $adminRole);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @param $moduleName
     * @param $permissions
     * @return void
     */
    private function createAdminPermissions($moduleName = null, $permissions, $role): void
    {
        if ($moduleName) {
            $module = Module::firstOrCreate(['name' => $moduleName]);
        }

        foreach ($permissions as $permission) {
            if ($module) {
                $permission['module_id'] = $module->id;
            }
            $permission = Permission::create($permission);

            $permission->assignRole($role);
        }
    }
}
