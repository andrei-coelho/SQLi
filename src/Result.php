<?php 

namespace SQLi;

class Result {

    private $pdo;

    public function __construct(\PDOStatement $pdo){
        $this->pdo = $pdo;
    }

    public function fetchAll(){
        return $this->pdo->fetchAll();
    }

    public function fetchAllAssoc(){
        return $this->pdo->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchAllUnique(){
        return $this->pdo->fetchAll(\PDO::FETCH_UNIQUE);
    }

    public function fetchAllClass($class){
        return $this->pdo->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function fetchAssoc(){
        return $this->pdo->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchClass($class){
        $this->pdo->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $this->pdo->fetch();
    }

    public function fetch(){
        return $this->pdo->fetch(\PDO::FETCH_NUM);
    }


    /**
     * row counts...
     */

    public function rowCount(){
        return $this->pdo->rowCount();
    }

    // alias of rowCount
    public function numRows(){
        return $this->rowCount();
    }

    // alias of rowCount
    public function count(){
        return $this->rowCount();
    }

    // alias of rowCount
    public function size(){
        return $this->rowCount();
    }

}