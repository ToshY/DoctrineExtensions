<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @link https://dev.mysql.com/doc/refman/8.0/en/gis-class-point.html
 */
class Point extends FunctionNode
{
    public $latitude;

    public $longitude;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'POINT(%s %s)',
            $sqlWalker->walkArithmeticPrimary($this->latitude),
            $sqlWalker->walkArithmeticPrimary($this->longitude)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->latitude = $parser->ArithmeticPrimary();
        $this->longitude = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
