<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = file_get_contents("database/data/roles.json",'r');
        $roleDatas = json_decode($file);

        $count = Role::all()->count();
        if ($count != 0) return;
        foreach ($roleDatas as $input) {
            Role::create([
                "name" => $input->name,
                "description" => $input->description,
                "is_default" => $input->is_default,
                "permissions" => $input->permissions
            ]);
        }

    }
}
