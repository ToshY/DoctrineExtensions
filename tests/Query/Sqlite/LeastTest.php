<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

final class LeastTest extends SqliteTestCase
{
    public function testLeast(): void
    {
        $this->assertDqlProducesSql(
            "SELECT LEAST(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT MIN(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
