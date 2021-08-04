<?php
  class Post {

    private $conn;
    private $table = 'secret';

    public $hash;
    public $secret_text;
    public $view_limit;
    public $created_at;
    public $expires_at;

    public function __construct($db) {
      $this->conn = $db;
    }


    public function create() {

      $query = 'INSERT INTO ' . $this->table . ' SET secret_hash = :secret_hash, secret_text = :secret_text, view_limit = :view_limit, created_at = :created_at,expires_at = :expires_at';

      $stmt = $this->conn->prepare($query);

      $this->secret_hash = htmlspecialchars(strip_tags($this->secret_hash));
      $this->secret_text = htmlspecialchars(strip_tags($this->secret_text));
      $this->view_limit = htmlspecialchars(strip_tags($this->view_limit));
      $this->created_at= htmlspecialchars(strip_tags($this->created_at));
      $this->expires_at = htmlspecialchars(strip_tags($this->expires_at));

      $stmt->bindParam(':secret_hash', $this->secret_hash);
      $stmt->bindParam(':secret_text', $this->secret_text);
      $stmt->bindParam(':view_limit', $this->view_limit);
      $stmt->bindParam(':created_at', $this->created_at);
      $stmt->bindParam(':expires_at', $this->expires_at);


      if($stmt->execute()) {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);
      return false;
      }


    public function read() {

      $query = 'SELECT secret_hash,secret_text,view_limit,created_at,expires_at FROM ' . $this->table . ' WHERE secret_hash = ? LIMIT 0,1 ' ;

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->secret_hash);

      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->secret_hash = $row['secret_hash'];
      $this->secret_text = $row['secret_text'];
      $this->view_limit = $row['view_limit'];
      $this->created_at = $row['created_at'];
      $this->expires_at = $row['expires_at'];
    }

    public function update() {
      $query = 'UPDATE ' . $this->table . ' SET view_limit = view_limit-1 WHERE secret_hash = ?  ';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->secret_hash);

      $stmt->execute();

    }

    public function delete() {

      $query = 'DELETE FROM ' . $this->table . ' WHERE view_limit <1 OR expires_at < NOW()';

      $stmt = $this->conn->prepare($query);

      $this->secret_hash = htmlspecialchars(strip_tags($this->secret_hash));

      $stmt-> bindParam(':secret_hash', $this->secret_hash);

      if($stmt->execute()) {
        return true;
      }

      printf("Error: $s.\n", $stmt->error);

      return false;
      }


  }