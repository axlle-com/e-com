<?php

use App\Common\Models\User\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    public function up()
    {
        $user = User::query()->where('id', 6)->first();
        if ($user) {
            $role = Role::create(['name' => 'admin']);
            $permission = Permission::create(['name' => config('app.permission_entrance_allowed')]);
            $role->givePermissionTo($permission);
            $role->syncPermissions($permission);
            $permission->syncRoles($role);
            $user->assignRole('admin');

            $role = Role::create(['name' => 'employee']);
            $permission = Permission::where('name', config('app.permission_entrance_allowed'))->first();
            $role->givePermissionTo($permission);
            $role->syncPermissions($permission);
            $permission->syncRoles($role);
            $user->assignRole('employee');
        }
        $user = User::query()->where('id', 7)->first();
        if ($user) {
            $role = Role::create(['name' => 'customer']);
            $user->assignRole('customer');
        }
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('ax_rights_model_has_permissions')->truncate();
        DB::table('ax_rights_model_has_roles')->truncate();
        DB::table('ax_rights_role_has_permissions')->truncate();
        DB::table('ax_rights_permissions')->truncate();
        DB::table('ax_rights_roles')->truncate();

        Schema::enableForeignKeyConstraints();
    }
};
