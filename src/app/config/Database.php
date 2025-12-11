<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();

            $this->dbh = null;
        }
    }

    public function query($sql) {
        if($this->dbh){
            $this->stmt = $this->dbh->prepare($sql);
        }
    }

    public function bind($param, $value, $type = null) {
        if(!$this->dbh) return;

        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        if(!$this->dbh) return false;
        return $this->stmt->execute();
    }

    public function resultSet() {
        if(!$this->dbh) return [];
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single() {
        if(!$this->dbh) return false;
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount() {
        if(!$this->dbh) return 0;
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        if(!$this->dbh) return 0;
        return $this->dbh->lastInsertId();
    }
}
