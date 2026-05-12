<?php

namespace Geccomedia\Weclapp\Tests\NotSupported;

use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\NotSupportedException;
use Geccomedia\Weclapp\Query\Builder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class BuilderTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    private function makeBuilder(): Builder
    {
        return new Builder(app(Connection::class), new Grammar, new Processor);
    }

    public function test_select_sub_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->makeBuilder()->selectSub('sub', 'alias');
    }

    public function test_where_raw_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->makeBuilder()->whereRaw('1=1');
    }

    public function test_truncate_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->makeBuilder()->truncate();
    }

    public function test_raw_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->makeBuilder()->raw('1');
    }

    public function test_union_throws(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->makeBuilder()->union($this->makeBuilder());
    }

    public function test_where_sub_throws(): void
    {
        // Passing a Closure as the value of where() with a scalar operator
        // routes through the base Builder into whereSub(), which we override
        // to throw NotSupportedException.
        $this->expectException(NotSupportedException::class);
        $this->makeBuilder()->from('unit')->where('col', '=', function ($q) {});
    }
}
