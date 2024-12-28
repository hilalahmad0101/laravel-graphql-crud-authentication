<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

final readonly class LoginUser
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $validator = Validator::make($args['input'], [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'messages' => $validator->errors()->all(),
                'data' => null
            ];
        }

        $user = User::whereEmail($args['input']['email'])->first();
        if (!$user) {
            return [
                'success' => false,
                'messages' => ['Invalid email and password'],
                'data' => null,
            ];
        }

        if (!Hash::check($args['input']['password'], $user->password)) {
            return [
                'success' => false,
                'messages' => ['Invalid email and password'],
                'data' => null,
            ];
        }

        // $auth_user=Auth::attempt([
        //     'email'=>$args['input']['email'],
        //     'password'=>$args['input']['password']
        // ];

        $token = $user->createToken('Api Token')->plainTextToken;


        return [
            'success' => true,
            'messages' => [
                'Login successfully'
            ],
            'data' => $user,
            'token' => $token
        ];





    }
}
