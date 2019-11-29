<?php


namespace MyQueryBuilder;


class QueryFactory
{
    private $query;
    private $bindParams;

    public function __construct()
    {
        $this->newSelect();
    }

    public function newSelect()
    {
        $this->query = '';
        $this->bindParams = [];
        return $this;
    }

    public function insert($table)
    {
        $this->query = "INSERT INTO `{$table}`";

        return $this;
    }

    public function values($data)
    {
        $this->bindParams = array_merge($this->bindParams, $data);

        $string = '';
        foreach ($data as $key => $value)
        {
            $keys = "`".substr($key, 1)."`, ";
            $string .= $keys;
        }
        $keys = substr(trim($string," "), 0, -1);
        $values = implode(", ", array_keys($data));

        $this->query .= "({$keys}) VALUES ({$values})";

        return $this;
    }

    public function update($table)
    {
        $this->query .= "UPDATE `{$table}`";

        return $this;
    }

    public function set($data)
    {
        $this->bindParams = array_merge($this->bindParams, $data);

        $string = "";
        foreach (array_keys($data) as $key)
        {
            $value = $key;
            $key = substr($key, 1);
            $string .= "`{$key}`={$value}, ";
        }
        $string = substr(trim($string, ' '), 0, -1);

        $this->query .= " SET {$string}";

        return $this;
    }

    public function delete()
    {
        $this->query = "DELETE";

        return $this;
    }

    public function cols($arr)
    {
        $this->query .= "SELECT ".implode(', ',array_values($arr));

        return $this;
    }

    public function from($table)
    {
        $this->query .= " FROM `{$table}`";

        return $this;
    }

    public function where($data)
    {
        $this->bindParams = array_merge($this->bindParams, $data);

        $string = "";
        foreach (array_keys($data) as $key)
        {
            $value = $key;
            $key = substr($key, 1);
            $string .= "`{$key}`={$value}, ";
        }
        $string = substr(trim($string, " "), 0, -1);

        $this->query .= " WHERE {$string}";

        return $this;
    }

    public function getStatement()
    {
        return $this->query;
    }

    public function getBindParams()
    {
        return $this->bindParams;
    }
}

?>