<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

/**
 * @author Alexey Kalinin <nitso@yandex.ru>
 */
final class TruncTest extends OracleTestCase
{
    public function testFullQuery(): void
    {
        $dql = 'SELECT TRUNC(d.created, \'YYYY\') FROM DoctrineExtensions\\Tests\\Entities\\Date d';
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT TRUNC(d0_.created, \'YYYY\') AS sclr_0 FROM Date d0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testShortQuery(): void
    {
        $dql = 'SELECT TRUNC(d.created) FROM DoctrineExtensions\\Tests\\Entities\\Date d';
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT TRUNC(d0_.created) AS sclr_0 FROM Date d0_';
        $this->assertEquals($sql, $q->getSql());
    }
}
