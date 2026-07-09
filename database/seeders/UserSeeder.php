<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::create([
            'Username' => 'superadmin',
            'Password' => Hash::make('password123'),
            'Role' => 'Superadmin',
            'is_active' => Carbon::now(),
        ]);

        // Admin
        User::create([
            'Username' => 'admin',
            'Password' => Hash::make('password123'),
            'Role' => 'Admin',
            'is_active' => Carbon::now(),
        ]);

        // User Biasa
        User::create([
            'Username' => 'user',
            'Password' => Hash::make('password123'),
            'Role' => 'User',
            'is_active' => Carbon::now(),
        ]);

        echo "✅ Users seeded successfully!\n";
        echo "Superadmin: superadmin / password123\n";
        echo "Admin: admin / password123\n";
        echo "User: user / password123\n";
    } 
}