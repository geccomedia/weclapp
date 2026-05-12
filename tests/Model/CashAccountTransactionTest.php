<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\CashAccountTransaction;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class CashAccountTransactionTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_cash_account_transaction_account_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountTransaction)->account());
    }

    public function test_cash_account_transaction_cash_account_sheet_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountTransaction)->cashAccountSheet());
    }

    public function test_cash_account_transaction_created_by_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountTransaction)->createdBy());
    }

    public function test_cash_account_transaction_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountTransaction)->currency());
    }

    public function test_cash_account_transaction_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountTransaction)->paymentMethod());
    }

    public function test_cash_account_transaction_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountTransaction)->tax());
    }
}
