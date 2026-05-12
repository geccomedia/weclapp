<?php

namespace Geccomedia\Weclapp\Tests\NotSupported;

use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class ConnectionTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_statement_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->statement('SELECT 1');
    }

    public function test_affecting_statement_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->affectingStatement('SELECT 1');
    }

    public function test_unprepared_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->unprepared('SELECT 1');
    }

    public function test_cursor_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->cursor('SELECT 1');
    }

    public function test_transaction_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->transaction(function () {});
    }

    public function test_begin_transaction_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->beginTransaction();
    }

    public function test_commit_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->commit();
    }

    public function test_roll_back_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->rollBack();
    }

    public function test_transaction_level_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->transactionLevel();
    }

    public function test_pretend_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->pretend(function () {});
    }

    public function test_raw_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->raw('1');
    }

    public function test_scalar_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->scalar('SELECT 1');
    }

    public function test_prepare_bindings_returns_input(): void
    {
        $bindings = ['a' => 1];
        $result = app(Connection::class)->prepareBindings($bindings);
        $this->assertSame($bindings, $result);
    }

    public function test_get_database_name_returns_weclapp_api(): void
    {
        $this->assertSame('weclapp_api', app(Connection::class)->getDatabaseName());
    }

    public function test_select_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->select('SELECT 1');
    }

    public function test_select_one_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->selectOne('SELECT 1');
    }

    public function test_insert_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->insert('INSERT INTO foo VALUES (1)');
    }

    public function test_update_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->update('UPDATE foo SET bar = 1');
    }

    public function test_delete_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        app(Connection::class)->delete('DELETE FROM foo WHERE id = 1');
    }
}
