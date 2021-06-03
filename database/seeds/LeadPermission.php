<?php

use Illuminate\Database\Seeder;

class LeadPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view lead', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage lead', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view lead', 'manage lead']);
    }
}
