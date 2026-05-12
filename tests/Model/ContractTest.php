<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Models\Contract;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ContractTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_authorization_unit_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->authorizationUnit());
    }

    public function test_creator_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->creator());
    }

    public function test_invoice_recipient_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->invoiceRecipient());
    }

    public function test_non_standard_input_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->nonStandardInputTax());
    }

    public function test_non_standard_tax_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->nonStandardTax());
    }

    public function test_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->party());
    }

    public function test_payment_method_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->paymentMethod());
    }

    public function test_record_currency_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->recordCurrency());
    }

    public function test_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->responsibleUser());
    }

    public function test_technical_contact_person_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->technicalContactPerson());
    }

    public function test_term_of_payment_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->termOfPayment());
    }

    public function test_ticket_service_level_agreement_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Contract)->ticketServiceLevelAgreement());
    }

    // -------------------------------------------------------------------------
    // Actions  (POST /contract/id/{id}/…)
    // -------------------------------------------------------------------------

    public function test_create_contract_document_action(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Contract;
        $model->exists = true;
        $model->id = '1';
        $model->createContractDocument();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:contract/id/1/createContractDocument')
        );
    }

    public function test_download_latest_contract_document_pdf_action(): void
    {
        Event::fake();

        $this->mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response(200, [], '{}'));

        $model = new Contract;
        $model->exists = true;
        $model->id = '1';
        $model->downloadLatestContractDocumentPdf();

        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:contract/id/1/downloadLatestContractDocumentPdf')
        );
    }
}
