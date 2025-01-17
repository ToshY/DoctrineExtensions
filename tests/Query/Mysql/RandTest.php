<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class RandTest extends MysqlTestCase
{
    public function testRandWithParameter(): void
    {
        $this->assertDqlProducesSql(
            "SELECT RAND(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT RAND(2) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testRandWithoutParameter(): void
    {
        $this->assertDqlProducesSql(
            "SELECT RAND() from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT RAND() AS sclr_0 FROM Blank b0_'
        );
    }
}
