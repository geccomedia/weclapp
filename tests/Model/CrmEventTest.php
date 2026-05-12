<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\CrmEvent;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class CrmEventTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_crm_event_calendar_event_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CrmEvent)->calendarEvent());
    }

    public function test_crm_event_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CrmEvent)->contact());
    }

    public function test_crm_event_creator_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CrmEvent)->creatorUser());
    }

    public function test_crm_event_opportunity_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CrmEvent)->opportunity());
    }

    public function test_crm_event_party_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CrmEvent)->party());
    }
}
