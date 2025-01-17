<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class TimeToSecTest extends MysqlTestCase
{
    public function testTimeToSec(): void
    {
        $this->assertDqlProducesSql(
            "SELECT TIMETOSEC(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT TIME_TO_SEC(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
