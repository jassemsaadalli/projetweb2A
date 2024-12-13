
<?php
class Database {
    private $host = "localhost";
    private $db_name = "test";
    private $username = "root"; 
    private $password = ""; 
    public $conn;

    public function getConnection() {
        $this->conn = null; // Initialize connection as null
        
        try {
            // Attempt to create a PDO connection
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            
            // Set error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
         
        } catch (PDOException $exception) {
            // Error message
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn; // Return the connection (or null on failure)
    }
}

// Example usage
$database = new Database();
$connection = $database->getConnection();

