<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'password' => fake()->password(),
            'account_number' => fake()->regexify('[A-Za-z0-9]{20}'),
            'balance' => fake()->randomFloat(2, 0, 9999999999999.99),
        ];
    }
}
