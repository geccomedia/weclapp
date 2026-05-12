<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\Query\Builder;
use Geccomedia\Weclapp\Query\Grammars\Grammar;
use Geccomedia\Weclapp\Query\Processors\Processor;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Covers Grammar::buildWheres() branches that are not exercised by the main
 * QueryGrammarTest — specifically the NotInRaw elseif path, which is produced
 * by Builder::whereIntegerNotInRaw() and must be compiled identically to a
 * plain NotIn clause.
 */
class QueryGrammarNotInRawTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    private function makeBuilder(): Builder
    {
        return new Builder(app(Connection::class), new Grammar, new Processor);
    }

    /**
     * whereIntegerInRaw() stores an 'InRaw' where clause. Grammar::buildWheres()
     * must remap it to 'In' and produce a `column-in=[...]` pair.
     */
    public function test_in_raw_compiles_to_in_param(): void
    {
        $grammar = new Grammar;
        $query = $this->makeBuilder()->from('unit');

        // whereIntegerInRaw() is the public API that produces an 'InRaw' where.
        $query->whereIntegerInRaw('id', [1, 2, 3]);

        $this->assertSame('InRaw', $query->wheres[0]['type']);

        $result = $grammar->buildWheres($query);

        $this->assertCount(1, $result);
        $this->assertSame('id-in', $result[0][0]);
        $this->assertSame(json_encode([1, 2, 3]), $result[0][1]);
    }

    /**
     * whereIntegerNotInRaw() stores a 'NotInRaw' where clause. Grammar::buildWheres()
     * must remap it to 'NotIn' and produce a `column-notin=[...]` pair.
     */
    public function test_not_in_raw_compiles_to_notin_param(): void
    {
        $grammar = new Grammar;
        $query = $this->makeBuilder()->from('unit');

        // whereIntegerNotInRaw() is the public API that produces a 'NotInRaw' where.
        $query->whereIntegerNotInRaw('id', [10, 20, 30]);

        $this->assertSame('NotInRaw', $query->wheres[0]['type']);

        $result = $grammar->buildWheres($query);

        $this->assertCount(1, $result);
        $this->assertSame('id-notin', $result[0][0]);
        $this->assertSame(json_encode([10, 20, 30]), $result[0][1]);
    }

    /**
     * A NotInRaw where clause injected directly (as Eloquent's eager-loader
     * would produce it) must compile identically to a NotIn clause.
     */
    public function test_not_in_raw_where_injected_directly_compiles_correctly(): void
    {
        $grammar = new Grammar;
        $query = $this->makeBuilder()->from('unit');

        // Simulate what Eloquent writes when eager-loading with integer keys.
        $query->wheres[] = [
            'type' => 'NotInRaw',
            'column' => 'id',
            'values' => [1, 2, 3],
            'boolean' => 'and',
        ];

        $result = $grammar->buildWheres($query);

        $this->assertCount(1, $result);
        $this->assertSame('id-notin', $result[0][0]);
        $this->assertSame(json_encode([1, 2, 3]), $result[0][1]);
    }
}
