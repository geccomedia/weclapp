<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\AccountingTransaction;
use Geccomedia\Weclapp\Models\ArchivedEmail;
use Geccomedia\Weclapp\Models\CustomAttributeDefinition;
use Geccomedia\Weclapp\Models\FinancialYear;
use Geccomedia\Weclapp\Models\Notification;
use Geccomedia\Weclapp\Models\NumberRange;
use Geccomedia\Weclapp\Models\PropertyTranslation;
use Geccomedia\Weclapp\Models\Region;
use Geccomedia\Weclapp\Models\SalesChannel;
use Geccomedia\Weclapp\Models\UserRole;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ActionsATest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // ── AccountingTransaction ─────────────────────────────────────────────
    // collection-level POST (no id in docblock)

    public function test_accounting_transaction_batch_booking(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new AccountingTransaction)->batchBooking();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:accountingTransaction/batchBooking'));
    }

    // ── ArchivedEmail ─────────────────────────────────────────────────────
    // collection-level POST

    public function test_archived_email_remove_reference(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new ArchivedEmail)->removeReference();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:archivedEmail/removeReference'));
    }

    // ── CustomAttributeDefinition ─────────────────────────────────────────
    // collection-level GET

    public function test_custom_attribute_definition_read_order(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new CustomAttributeDefinition)->readOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:customAttributeDefinition/readOrder'));
    }

    // collection-level POST

    public function test_custom_attribute_definition_update_order(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new CustomAttributeDefinition)->updateOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:customAttributeDefinition/updateOrder'));
    }

    // ── FinancialYear ─────────────────────────────────────────────────────
    // collection-level POST

    public function test_financial_year_generate_periods(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new FinancialYear)->generatePeriods();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:financialYear/generatePeriods'));
    }

    // ── Notification ──────────────────────────────────────────────────────
    // collection-level POST

    public function test_notification_mark_read(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new Notification)->markRead();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:notification/markRead'));
    }

    // ── NumberRange ───────────────────────────────────────────────────────
    // collection-level GET

    public function test_number_range_missing_number_ranges(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new NumberRange)->missingNumberRanges();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:numberRange/missingNumberRanges'));
    }

    // ── PropertyTranslation ───────────────────────────────────────────────
    // collection-level GET

    public function test_property_translation_read_property_translations(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new PropertyTranslation)->readPropertyTranslations();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:propertyTranslation/readPropertyTranslations'));
    }

    // collection-level POST

    public function test_property_translation_update_property_translations(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new PropertyTranslation)->updatePropertyTranslations();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:propertyTranslation/updatePropertyTranslations'));
    }

    // ── SalesChannel ──────────────────────────────────────────────────────
    // collection-level GET

    public function test_sales_channel_active_sales_channels(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new SalesChannel)->activeSalesChannels();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesChannel/activeSalesChannels'));
    }

    // collection-level GET

    public function test_sales_channel_sales_channel_usage(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new SalesChannel)->salesChannelUsage();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:salesChannel/salesChannelUsage'));
    }

    // ── UserRole ──────────────────────────────────────────────────────────
    // collection-level POST

    public function test_user_role_disable_user_roles_during_trial(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new UserRole)->disableUserRolesDuringTrial();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:userRole/disableUserRolesDuringTrial'));
    }

    // collection-level POST

    public function test_user_role_enable_user_roles_during_trial(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new UserRole)->enableUserRolesDuringTrial();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:userRole/enableUserRolesDuringTrial'));
    }

    // ── Region ────────────────────────────────────────────────────────────

    public function test_region_responsible_user(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Region)->responsibleUser());
    }

    // collection-level POST

    public function test_region_reset_responsible_person(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        (new Region)->resetResponsiblePerson();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:region/resetResponsiblePerson'));
    }
}
