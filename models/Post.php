<?php

class Post
{

    private $__conn;
    private $__table = 'posts';

    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->__conn = $db;
    }

    public function createTable()
    {
        
        $sql = "CREATE TABLE posts (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(30) NOT NULL,
            body LONGTEXT NOT NULL,
            author VARCHAR(50),
            category_id INT(6) UNSIGNED,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        try {if ($this->__conn->query($sql)) {
            echo "Table posts created successfully";
            return true;
        }
        } catch (PDOException $e) {
            echo 'error in creating this table' . $e->getMessage();
        }

    }

    public function read()
    {$query = 'SELECT
    c.name as category_name,
    p.id,
    p.category_id,
    p.title,
    p.body,
    p.author
     FROM ' . $this->__table . ' p
     LEFT JOIN
     categories c ON p.category_id=c.id
     ';

        $stmt = $this->__conn->prepare($query);
        $stmt->execute();
        return $stmt;

    }

    public function read_single()
    {$query = 'SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author
         FROM ' . $this->__table . ' p
         LEFT JOIN
         categories c ON p.category_id=c.id

         WHERE
            p.id=?
         ';

        $stmt = $this->__conn->prepare($query);

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404);
            echo 'post not found';
            die(203);
        }

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }

    public function create()
    {

        $query = '
        INSERT INTO ' . $this->__table . '
         SET
        title=:title,
        body=:body,
        author=:author,
        category_id=:category_id
        ;';

        $stmt = $this->__conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

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

    public function update()
    {

        $querySelect = 'SELECT id FROM ' . $this->__table . '  WHERE  id=? ';
        $stmtS = $this->__conn->prepare($querySelect);
        $stmtS->bindParam(1, $this->id);
        $stmtS->execute();
        $row = $stmtS->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404);
            echo 'post not found';
            die(203);
        }

        $queryUpdate = '
        UPDATE ' . $this->__table . '
         SET
        title=:title,
        body=:body,
        author=:author,
        category_id=:category_id

        WHERE (`id` = :id) ';

        $stmt = $this->__conn->prepare($queryUpdate);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        printf("error : %s ./n", $stmt->error);
        return false;
    }

    public function delete()
    {
        $querySelect = 'SELECT id FROM ' . $this->__table . '  WHERE  id=? ';
        $stmt = $this->__conn->prepare($querySelect);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404);
            echo 'post not found';
            die(203);
        }
        $querydelte = 'Delete FROM ' . $this->__table . '  WHERE  id=? ';

        $stmt = $this->__conn->prepare($querydelte);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {

            return true;
        }
        printf("error : %s ./n", $stmt->error);
        return false;

    }
}
