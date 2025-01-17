<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class YearTest extends MysqlTestCase
{
    public function testYear(): void
    {
        $this->assertDqlProducesSql(
            "SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT YEAR(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
