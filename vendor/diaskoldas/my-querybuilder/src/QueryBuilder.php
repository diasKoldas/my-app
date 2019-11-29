<?php


namespace MyQueryBuilder;

use PDO;

class QueryBuilder
{
    private $pdo;

    private $queryFactory;

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }

    public function getAll($table)
    {
        $this->queryFactory->newSelect();

        $this->queryFactory
            ->cols(['*'])
            ->from($table);

        $sth = $this->pdo->prepare($this->queryFactory->getStatement());
        $sth->execute($this->queryFactory->getBindParams());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($table, $id)
    {
        $this->queryFactory->newSelect();

        $this->queryFactory
            ->cols(['*'])
            ->from($table)
            ->where([':id' => $id]);

        $sth = $this->pdo->prepare($this->queryFactory->getStatement());
        $sth->execute($this->queryFactory->getBindParams());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($table, $id)
    {
        $this->queryFactory->newSelect();

        $this->queryFactory
            ->delete()
            ->from($table)
            ->where([':id' => $id]);

        $sth = $this->pdo->prepare($this->queryFactory->getStatement());
        $sth->execute($this->queryFactory->getBindParams());
    }

    public function add($table, $data)
    {
        $this->queryFactory->newSelect();

        $this->queryFactory
            ->insert($table)
            ->values($data);

        $sth = $this->pdo->prepare($this->queryFactory->getStatement());
        $sth->execute($this->queryFactory->getBindParams());
    }

    public function update($table, $data, $id)
    {
        $this->queryFactory->newSelect();

        $this->queryFactory
            ->update($table)
            ->set($data)
            ->where([':id' => $id]);

        $sth = $this->pdo->prepare($this->queryFactory->getStatement());
        $sth->execute($this->queryFactory->getBindParams());
    }
}

?>