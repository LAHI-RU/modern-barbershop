<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['nullable', 'in:user,staff'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'] ?? 'user',
            'is_active' => ($input['role'] ?? 'user') === 'staff' ? false : true,
        ]);

        // If a staff user signed up, create a Staff record linked to this user so staff can manage appointments.
        if (($input['role'] ?? 'user') === 'staff') {
            \App\Models\Staff::create([
                'name' => $input['name'],
                'bio' => null,
                'is_active' => false,
                'user_id' => $user->id,
            ]);
        }

        return $user;
    }
}
