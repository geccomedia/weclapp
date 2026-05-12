<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Ticket;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TicketTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // BelongsTo relations
    // -------------------------------------------------------------------------

    public function test_assigned_pooling_group_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->assignedPoolingGroup());
    }

    public function test_assigned_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->assignedUser());
    }

    public function test_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->contact());
    }

    public function test_contract_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->contract());
    }

    public function test_legacy_article_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->legacyArticle());
    }

    public function test_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->party());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->responsibleUser());
    }

    public function test_sales_order_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->salesOrder());
    }

    public function test_ticket_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->ticketCategory());
    }

    public function test_ticket_service_level_agreement_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->ticketServiceLevelAgreement());
    }

    public function test_ticket_status_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->ticketStatus());
    }

    public function test_ticket_type_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->ticketType());
    }

    public function test_ticket_channel_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Ticket)->ticketChannel());
    }

    // -------------------------------------------------------------------------
    // Instance-level actions (POST, exists=true)
    // -------------------------------------------------------------------------

    private function makeTicket(): Ticket
    {
        $m = new Ticket;
        $m->exists = true;
        $m->id = '1';

        return $m;
    }

    public function test_create_performance_record_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeTicket()->createPerformanceRecord();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:ticket/id/1/createPerformanceRecord'));
    }

    public function test_create_public_page_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeTicket()->createPublicPage();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:ticket/id/1/createPublicPage'));
    }

    public function test_disable_public_page_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeTicket()->disablePublicPage();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:ticket/id/1/disablePublicPage'));
    }

    public function test_link_sales_order_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeTicket()->linkSalesOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:ticket/id/1/linkSalesOrder'));
    }

    public function test_unlink_sales_order_action(): void
    {
        Event::fake();
        $this->mock(Client::class)->shouldReceive('send')->once()
            ->andReturn(new Response(200, [], '{}'));
        $this->makeTicket()->unlinkSalesOrder();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:ticket/id/1/unlinkSalesOrder'));
    }
}
