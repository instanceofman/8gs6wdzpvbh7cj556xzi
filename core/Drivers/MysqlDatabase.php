<?php

namespace Intass\Drivers;

use Intass\Database;

class MysqlDatabase extends Database
{
    /**
     * @return \PDO
     */
    protected $pdo;

    public function setup()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";

        $this->pdo = new \PDO($dsn, $this->username, $this->password);
    }

    public function query($query)
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($cmd, $args)
    {
        $statement = $this->pdo->prepare($cmd);
        $statement->execute($args);

        return $statement->rowCount() > 0;
    }
}
