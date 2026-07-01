<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\TicketAssignmentRule;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TicketAssignmentRuleTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_ticket_assignment_rule_assigned_pooling_group_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->assignedPoolingGroup());
    }

    public function test_ticket_assignment_rule_assignee_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->assigneeUser());
    }

    public function test_ticket_assignment_rule_responsible_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->responsibleUser());
    }

    public function test_ticket_assignment_rule_target_status_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->targetStatus());
    }

    public function test_ticket_assignment_rule_ticket_category_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->ticketCategory());
    }

    public function test_ticket_assignment_rule_ticket_type_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->ticketType());
    }

    public function test_ticket_assignment_rule_ticket_channel_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->ticketChannel());
    }

    public function test_ticket_assignment_rule_ticket_priority_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->ticketPriority());
    }

    public function test_ticket_assignment_rule_work_schedule_profile_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new TicketAssignmentRule)->workScheduleProfile());
    }
}
