<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone' => '+33612345678',
            'country' => 'France',
            'city' => 'Paris',
            'address' => '123 Rue de l\'Admin',
            'created_mode' => 'manual',
        ]);

        // Assigner le rôle admin
        $admin->assignRole('admin');

        // Créer d'autres utilisateurs
        User::factory()
            ->count(10)
            ->create()
            ->each(function (User $user) {
                $user->update([
                    'created_mode' => 'manual',
                    'created_by' => User::first()->id,
                ]);
            });
    }
}
