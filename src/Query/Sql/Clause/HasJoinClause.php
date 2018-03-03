<?php


namespace QueryMule\Query\Sql\Clause;

use QueryMule\Builder\Exception\SqlException;
use QueryMule\Query\Repository\RepositoryInterface;
use QueryMule\Query\Sql\Sql;
use QueryMule\Query\Sql\Statement\FilterInterface;
use QueryMule\Query\Sql\Statement\SelectInterface;

/**
 * Class HasJoinClause
 * @package QueryMule\Query\Sql\Clause
 */
trait HasJoinClause
{
    /**
     * @var bool
     */
    protected $ignoreOnClause = false;

    /**
     * @param string $type
     * @param RepositoryInterface $table
     * @param string|null $alias
     * @return Sql
     * @throws SqlException
     */
    final protected function joinClause($type, RepositoryInterface $table, $alias = null)
    {
        $this->ignoreOnClause = false;

        $sql = '';
        switch ($type) {
            case FilterInterface::LEFT_JOIN:
                $sql .= FilterInterface::LEFT_JOIN . ' ' . $table->getName();
                break;

            case "RIGHT JOIN":
                $sql .= FilterInterface::LEFT_JOIN . ' ' . $table->getName();
                break;

            case "INNER JOIN":
                break;

            case "OUTER JOIN":
                break;

            case "CROSS JOIN":
                break;

            default:
                throw new SqlException('Join type not supported.');
        }

        $sql .= !empty($alias) ? ' '.SelectInterface::AS.' '.$alias : ' ';

        return new Sql($sql);
    }

    /**
     * @param string $first
     * @param string|null $operator
     * @param string|null $second
     * @return Sql
     */
    final protected function onClause($first, $operator = null, $second = null, $clause = FilterInterface::ON)
    {
        $sql = '';
        $sql .= ($this->ignoreOnClause) ? FilterInterface::AND : $clause;
        $sql .= ' '.$first;
        $sql .= ' '.$operator;
        $sql .= ' '.$second;

        return new Sql($sql);
    }
}