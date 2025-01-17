<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @link https://docs.oracle.com/en/database/oracle/oracle-database/19/sqlrf/LISTAGG.html#GUID-B6E50D8E-F467-425B-9436-F7F8BF38D466
 * @author Alexey Kalinin <nitso@yandex.ru>
 */
class Listagg extends FunctionNode
{
    public ?Node $separator = null;

    public ?Node $listaggField = null;

    public OrderByClause $orderBy;

    /**
     * @var Node[]
     */
    public array $partitionBy = [];

    /**
     * @inheritdoc
     */
    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->listaggField = $parser->StringPrimary();

        if ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->separator = $parser->StringExpression();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

        if (!$lexer->isNextToken(Lexer::T_IDENTIFIER) || strtolower($lexer->lookahead->value) != 'within') {
            $parser->syntaxError('WITHIN GROUP');
        }
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_GROUP);

        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->orderBy = $parser->OrderByClause();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

        if ($lexer->isNextToken(Lexer::T_IDENTIFIER)) {
            if (strtolower($lexer->lookahead->value) != 'over') {
                $parser->syntaxError('OVER');
            }
            $parser->match(Lexer::T_IDENTIFIER);
            $parser->match(Lexer::T_OPEN_PARENTHESIS);

            if (!$lexer->isNextToken(Lexer::T_IDENTIFIER) || strtolower($lexer->lookahead->value) != 'partition') {
                $parser->syntaxError('PARTITION BY');
            }
            $parser->match(Lexer::T_IDENTIFIER);
            $parser->match(Lexer::T_BY);

            $this->partitionBy[] = $parser->StringPrimary();

            while ($lexer->isNextToken(Lexer::T_COMMA)) {
                $parser->match(Lexer::T_COMMA);
                $this->partitionBy[] = $parser->StringPrimary();
            }

            $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        }
    }

    /**
     * @inheritdoc
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $result = 'LISTAGG(' . $this->listaggField->dispatch($sqlWalker);
        if ($this->separator) {
            $result .= ', ' . $sqlWalker->walkStringPrimary($this->separator) . ')';
        } else {
            $result .= ')';
        }

        $result .= ' WITHIN GROUP (' . ltrim($sqlWalker->walkOrderByClause($this->orderBy)) . ')';

        if (count($this->partitionBy)) {
            $partitionBy = [];
            foreach ($this->partitionBy as $part) {
                $partitionBy[] = $part->dispatch($sqlWalker);
            }

            $result .= ' OVER (PARTITION BY ' . implode(', ', $partitionBy) . ')';
        }

        return $result;
    }
}
