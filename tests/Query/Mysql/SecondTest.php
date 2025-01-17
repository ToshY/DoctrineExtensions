<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class SecondTest extends MysqlTestCase
{
    public function testSecond():void
    {
        $this->assertDqlProducesSql(
            "SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT SECOND(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
