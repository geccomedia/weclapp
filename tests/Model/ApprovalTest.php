<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Approval;
use Geccomedia\Weclapp\Models\ApprovalGroup;
use Geccomedia\Weclapp\Models\ApprovalRule;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ApprovalTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    public function test_approval_requester_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Approval)->requester());
    }

    public function test_approval_rule_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Approval)->rule());
    }

    public function test_approval_change_status_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = $this->makeInstance(Approval::class);
        $model->changeStatus();
        $this->assertSql('POST:approval/id/1/changeStatus');
    }

    public function test_approval_group_has_no_relations(): void
    {
        $this->assertInstanceOf(ApprovalGroup::class, new ApprovalGroup);
    }

    public function test_approval_rule_requester_group_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ApprovalRule)->requesterGroup());
    }

    public function test_approval_rule_requester_person_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new ApprovalRule)->requesterPerson());
    }
}
