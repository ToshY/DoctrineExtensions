<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class CollateTest extends MysqlTestCase
{
    public function testCollate(): void
    {
        $this->assertDqlProducesSql(
            "SELECT COLLATE('A',latin1_german2_ci) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT 'A' COLLATE latin1_german2_ci AS sclr_0 FROM Blank b0_"
        );
    }
}
