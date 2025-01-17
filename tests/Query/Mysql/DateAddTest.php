<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class DateAddTest extends MysqlTestCase
{
    public function testDateAdd():void
    {
        $this->assertDqlProducesSql(
            "SELECT DATEADD(2, 5, 'MINUTE') from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT DATE_ADD(2, INTERVAL 5 MINUTE) AS sclr_0 FROM Blank b0_'
        );
    }
}
