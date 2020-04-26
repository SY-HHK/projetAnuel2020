<?php

require_once __DIR__ . "/database.env.php";

class DatabaseManager
{
    private $pdo;
    private static $sharedInstance;

    private function __construct()
    {
        $options = [
            'host=' . DB_HOST,
            'dbname=' . DB_NAME,
            'port=' . DB_PORT,
        ];
        $this->pdo = new PDO(DB_DRIVER.":".join(";", $options), DB_USER, DB_PASSWD);
    }

    //singleton
    public static function getInstance():DatabaseManager {
        if (!isset(self::$sharedInstance)) return self::$sharedInstance = new DatabaseManager();
        else return self::$sharedInstance;
    }

    protected function internalExec(string $sql, array $params): ?PDOStatement {
        $statement = $this->pdo->prepare($sql);
        if ($statement == false) {
            return null;
        };

        $success = $statement->execute($params);
        if (!$success) {
            return null;
        };

        return $statement;
    }

    public function test(string $filter)
    {
        $statement = $this->internalExec("SELECT * FROM artist WHERE lastname LIKE ?", [$filter . "%"]);
        print_r($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getAll(string $sql, $params):array
    {
        $statement = $this->internalExec($sql, $params);
        if ($statement) return $statement->fetchAll(PDO::FETCH_ASSOC);
        else return [];
    }

    public function findOne(string $sql, array $params):?array { //return null ou array
        $statement = $this->internalExec($sql, $params);
        if ($statement) {
            $line = $statement->fetch(PDO::FETCH_ASSOC);
            if ($line == false) {
                return null;
            }
            return $line;
        }
        else return null;
    }

    public function exec(string $sql, $params):bool
    {
        $statement = $this->internalExec($sql, $params);
        if ($statement) return true;
        else return false;
    }

    public function getLastInsertedId():string {
        return $this->pdo->lastInsertId();
    }
}