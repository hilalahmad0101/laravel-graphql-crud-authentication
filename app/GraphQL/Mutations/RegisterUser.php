<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

final readonly class RegisterUser
{
    /** @param  array{}  $args */
    public function __invoke($rootValue, array $args)
    {
        // Validate the input
        $validator = Validator::make($args['input'], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'messages' => $validator->errors()->all(),
                'data' => null,
            ];
        }

        // Create the user
        $user = User::create([
            'name' => $args['input']['name'],
            'email' => $args['input']['email'],
            'password' => $args['input']['password'],
        ]);

        return [
            'success' => true,
            'messages' => ['User created successfully'],
            'data' => $user,
        ];
    }
}
