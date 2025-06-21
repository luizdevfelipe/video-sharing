<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService 
{
    /**
     * Create a new user with the provided data.
     * @param array $data
     * @return User|null
     */
    public function createNewUser(array $data): ?User
    {
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            return null; 
        }

        $newUser = User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);

        return $newUser;
    }
}