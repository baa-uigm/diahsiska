<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'nidn' => '2019110052',
                'name' => 'Muhammad Aditya Sahrin',
                'username' => 'admin',
                'email' => 'admin@uigm.ac.id',
                'role' => 'admin',
                'password' => bcrypt('admin'),
                'fps' => 'admin',
            ],
            [
                'nidn' => '0229117101',
                'name' => 'Sumi Amariena Hamim',
                'username' => 'warek1',
                'email' => 'warek1@uigm.ac.id',
                'role' => 'warek',
                'password' => bcrypt('warek1'),
                'fps' => 'warek1',
            ],
            [
                'nidn' => '0229047502',
                'name' => 'Rudi Heriansyah',
                'username' => 'dekan_ilkom',
                'email' => 'dekan_ilkom@uigm.ac.id',
                'role' => 'dekan',
                'password' => bcrypt('dekan_ilkom'),
                'fps' => 'ilkom',
            ],
            [
                'nidn' => '0204079501',
                'name' => 'Atidira Dwi Hanani',
                'username' => 'kaprodi_k3',
                'email' => 'kaprodi_k3@uigm.ac.id',
                'role' => 'kaprodi',
                'password' => bcrypt('kaprodi_k3'),
                'fps' => 'k3',
            ],
        ];

        foreach ($userData as $key => $value) {
            User::create($value);
        }
    }
}
