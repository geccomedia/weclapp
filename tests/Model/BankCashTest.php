<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\BankAccount;
use Geccomedia\Weclapp\Models\CashAccount;
use Geccomedia\Weclapp\Models\Currency;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class BankCashTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // BankAccount – relations
    // -------------------------------------------------------------------------

    public function test_bank_account_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankAccount)->account());
    }

    public function test_bank_account_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new BankAccount)->currency());
    }

    public function test_bank_account_incidental_costs_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new BankAccount)->incidentalCostsOfMonetaryTrafficAccount());
    }

    public function test_bank_account_incidental_costs_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class,
            (new BankAccount)->incidentalCostsOfMonetaryTrafficTax());
    }

    // -------------------------------------------------------------------------
    // CashAccount – relations
    // -------------------------------------------------------------------------

    public function test_cash_account_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccount)->account());
    }

    public function test_cash_account_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccount)->currency());
    }

    public function test_cash_account_treasurer_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccount)->treasurer());
    }

    // -------------------------------------------------------------------------
    // Currency – HasMany relations
    // -------------------------------------------------------------------------

    public function test_currency_article_prices_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Currency)->articlePrices());
    }

    public function test_currency_article_supply_sources_relation(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Currency)->articleSupplySources());
    }

    // -------------------------------------------------------------------------
    // Currency – collection-level GET action (exists=false)
    // -------------------------------------------------------------------------

    public function test_currency_company_currency_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new Currency)->companyCurrency();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:currency/companyCurrency'));
    }
}
