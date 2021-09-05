<?php
// From Laravel documentation

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     */
    public function run()
    {
        $file = file_get_contents("database/data/users.json");
        $users = json_decode($file);

        $count = DB::table('users')->count();
        if ($count != 0) return;
        foreach ($users as $user) {
            $userRoleNames = $user->role;
            $entity = User::create([
                'account' => $user->account,
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make($user->password),
            ]);
            $query = Role::whereIn('name', $userRoleNames)->get();
            $entity->roles()->attach($query);
        }
    }
}
