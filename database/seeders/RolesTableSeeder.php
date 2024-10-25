<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'supar_admin'],
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'laboratory'],
            ['name' => 'doctor'],
            ['name' => 'collector'],
            ['name' => 'user'],
        ];
        
        // Insert the roles into the 'roles' table
        DB::table('roles')->insert($roles);
    }
}
