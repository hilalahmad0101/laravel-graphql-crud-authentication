<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;

final readonly class CreateCategories
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $validator = Validator::make($args['input'], [
            'name' => ['required', 'string', 'unique:categories,name']
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'messages' => $validator->errors()->all(),
                'data' => null
            ];
        }

        Category::create([
            'name' => $args['input']['name']
        ]);

        return [
            'success' => true,
            'messages' => ['Category create successfully'],
            'category' => null,
        ];
    }
}
