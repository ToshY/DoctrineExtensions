<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Entities\Date;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

final class ExtractFunctionTest extends PostgresqlTestCase
{
    public function testExtract(): void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select('extract(EPOCH FROM dt.created)')
            ->from(Date::class, 'dt');

        $expected = 'SELECT EXTRACT(EPOCH FROM d0_.created) AS sclr_0 FROM Date d0_';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
