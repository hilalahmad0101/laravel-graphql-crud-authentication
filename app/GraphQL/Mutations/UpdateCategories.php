<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final readonly class UpdateCategories
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $validator = Validator::make($args['input'], [
            'name' => [
                'required',
                'string',
                Rule::unique('categories', 'name')->ignore($args['input']['id'], 'id'),
            ],
        ]);


        if ($validator->fails()) {
            return [
                'success' => false,
                'messages' => $validator->errors()->all(),
                'data' => null
            ];
        }

        Category::where('id', $args['input']['id'])->update([
            'name' => $args['input']['name']
        ]);

        return [
            'success' => true,
            'messages' => ['Category Update successfully'],
            'data' => null,
        ];
    }
}
