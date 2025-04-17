<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
final class AccountControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $accounts = Account::factory()->count(3)->create();

        $response = $this->get(route('accounts.index'));

        $response->assertOk();
        $response->assertViewIs('account.index');
        $response->assertViewHas('accounts');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccountController::class,
            'store',
            \App\Http\Requests\AccountStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $username = fake()->userName();
        $password = fake()->password();
        $account_number = fake()->word();

        $response = $this->post(route('accounts.store'), [
            'username' => $username,
            'password' => $password,
            'account_number' => $account_number,
        ]);

        $accounts = Account::query()
            ->where('username', $username)
            ->where('password', $password)
            ->where('account_number', $account_number)
            ->get();
        $this->assertCount(1, $accounts);
        $account = $accounts->first();

        $response->assertRedirect(route('account.index'));
    }
}
