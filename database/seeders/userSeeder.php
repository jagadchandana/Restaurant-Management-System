<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Repositories\Eloquent\User\UserInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userInterface = App()->make(UserInterface::class);
        $array = [
            [
                'name' => 'Manager',
                'email' => 'manager@mail.com',
                'role' => RoleEnum::Manager->value,
                'password' => Hash::make('1qaz2wsx'),
            ],
            [
                'name' => 'Kitchen Manager',
                'email' => 'kitchen.manager@mail.com',
                'role' => RoleEnum::KitchenManager->value,
                'password' => Hash::make('1qaz2wsx'),
            ],

        ];
        foreach ($array as $key => $item) {
            if (! $userInterface->existsByColumn(['email' => $item['email']])) {
                $userInterface->create($item);
            }
        }
    }
}
