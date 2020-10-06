<?php
  class Database {
    private $host = 'localhost';
    private $db_name = 'dealership';
    private $username = 'public_web_user';
    private $password = '1234';
    private $conn;

    public function connect() {
      // Point the connection to NULL.
      $this->conn = NULL;

      // Connect to the database.
      try {
        // Attempt to connect to the database.
        $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);

        // Set PDO exception.
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch(PDOException $e) {
        // If the connection fails.
        echo "Connection error: " . $e->getMessage();

        // Set the http response code.
        http_response_code(500);

        die();
      }

      // Return the connection.
      return $this->conn;
    }
  }
?>
