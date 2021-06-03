<?php

use Illuminate\Database\Seeder;

class PetPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view pet', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage pet', 'api');

    // Assign new permissions to admin group
    $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
    $adminRole->givePermissionTo(['view pet', 'manage pet']);
    }
}
