<?php

class Category {

    
    private $__conn;
    private $__table = 'categories';

    public $id;
    public $name;
    public $created_at;

    public function __construct($db)
    {
        $this->__conn = $db;
    }

    public function createTable()
    {
        
        $sql = "CREATE TABLE categories (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
           
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        try {if ($this->__conn->query($sql)) {
            echo "Table posts created successfully";
            die();
            
        }
        } catch (PDOException $e) {
            echo 'error in creating this table' . $e->getMessage();
        }

    }


    public function create()
    {

        $query = '
        INSERT INTO ' . $this->__table . '
         SET
        name=:name
       
        ;';

        $stmt = $this->__conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
     

        $stmt->bindParam(':name', $this->name);


        try {
            $stmt = $stmt->execute();
            if ($stmt) {

                return true;
            }
        } catch (PDOException $e) {
            echo 'error in creating this post' . $e->getMessage();
            return false;
        }

    }


    public function read()
    {$query = 'SELECT *FROM ' . $this->__table . ' 
     ';

        $stmt = $this->__conn->prepare($query);
        $stmt->execute();
        return $stmt;

    }



}