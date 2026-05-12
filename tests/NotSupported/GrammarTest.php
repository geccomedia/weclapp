<?php

namespace Geccomedia\Weclapp\Tests\NotSupported;

use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Query\Builder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class GrammarTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    private function makeBuilder(): Builder
    {
        $grammar = new Grammar;

        return new Builder(app(Connection::class), $grammar, new Processor);
    }

    public function test_supports_savepoints_returns_false(): void
    {
        $this->assertFalse((new Grammar)->supportsSavepoints());
    }

    public function test_compile_insert_using_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        (new Grammar)->compileInsertUsing($this->makeBuilder(), ['col'], 'SELECT 1');
    }

    public function test_compile_insert_or_ignore_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        (new Grammar)->compileInsertOrIgnore($this->makeBuilder(), [['col' => 'val']]);
    }

    public function test_compile_joins_throws(): void
    {
        // compileJoins() is protected; invoke it via reflection to confirm it
        // throws NotSupportedException regardless of the joins value passed.
        $this->expectException(NotSupportedException::class);
        $method = new \ReflectionMethod(Grammar::class, 'compileJoins');
        $method->setAccessible(true);
        $method->invoke(new Grammar, $this->makeBuilder(), []);
    }
}
