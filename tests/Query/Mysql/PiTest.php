<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class PiTest extends MysqlTestCase
{
    public function testPi(): void
    {
        $this->assertDqlProducesSql(
            "SELECT PI() from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT PI() AS sclr_0 FROM Blank b0_'
        );
    }
}
