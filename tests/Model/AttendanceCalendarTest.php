<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Attendance;
use Geccomedia\Weclapp\Models\Calendar;
use Geccomedia\Weclapp\Models\CalendarEvent;
use Geccomedia\Weclapp\Tests\Concerns\MocksClient;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class AttendanceCalendarTest extends OrchestraTestCase
{
    use MocksClient, UsesServiceProvider;

    // -------------------------------------------------------------------------
    // Attendance – relations
    // -------------------------------------------------------------------------

    public function test_attendance_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Attendance)->user());
    }

    // -------------------------------------------------------------------------
    // Attendance – collection-level GET action (exists=false)
    // -------------------------------------------------------------------------

    public function test_attendance_current_attendance_action(): void
    {
        Event::fake();
        $this->mockClient();
        (new Attendance)->currentAttendance();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'GET:attendance/currentAttendance'));
    }

    // -------------------------------------------------------------------------
    // Attendance – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_attendance_log_off_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new Attendance;
        $model->exists = true;
        $model->id = '1';
        $model->logOff();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:attendance/id/1/logOff'));
    }

    public function test_attendance_log_on_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new Attendance;
        $model->exists = true;
        $model->id = '1';
        $model->logOn();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:attendance/id/1/logOn'));
    }

    // -------------------------------------------------------------------------
    // Calendar – relations
    // -------------------------------------------------------------------------

    public function test_calendar_owner_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Calendar)->owner());
    }

    // -------------------------------------------------------------------------
    // Calendar – instance-level POST actions (exists=true)
    // -------------------------------------------------------------------------

    public function test_calendar_delete_calendar_and_move_events_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new Calendar;
        $model->exists = true;
        $model->id = '1';
        $model->deleteCalendarAndMoveEvents();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:calendar/id/1/deleteCalendarAndMoveEvents'));
    }

    public function test_calendar_import_ical_action(): void
    {
        Event::fake();
        $this->mockClient();
        $model = new Calendar;
        $model->exists = true;
        $model->id = '1';
        $model->importiCal();
        Event::assertDispatched(QueryExecuted::class, fn ($e) => str_contains((string) $e->sql, 'POST:calendar/id/1/importiCal'));
    }

    // -------------------------------------------------------------------------
    // CalendarEvent – relations
    // -------------------------------------------------------------------------

    public function test_calendar_event_calendar_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CalendarEvent)->calendar());
    }

    public function test_calendar_event_concerning_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CalendarEvent)->concerning());
    }

    public function test_calendar_event_contact_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CalendarEvent)->contact());
    }

    public function test_calendar_event_user_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CalendarEvent)->user());
    }
}
