<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;
use DoctrineExtensions\Tests\Entities\Date;

class DatePartTest extends PostgresqlTestCase
{
    public function testDatePart(): void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("date_part('YEAR', dt.created)")
            ->from(Date::class, 'dt');

        $expected = "SELECT DATE_PART('YEAR', d0_.created) AS sclr_0 FROM Date d0_";

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
