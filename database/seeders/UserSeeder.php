<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name', 'ADMIN')->first();
        $roleUser = Role::where('name', 'SALES')->first();

        $user = User::create([
            'first_name' => 'Johnny',
            'last_name' => 'Doe',
            'username' => 'admin',
            'email' => 'admin@admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_active' => 'y'
        ]);
        $user->roles()->attach($roleAdmin);

        User::factory(3)->create()->each(function($user) use($roleAdmin) {
            $user->roles()->attach($roleAdmin->id);
        });
        User::factory(10)->create()->each(function($user) use($roleUser) {
            $user->roles()->attach($roleUser->id);
        });
    }
}
