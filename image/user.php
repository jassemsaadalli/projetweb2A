<?php
require_once 'C:\xampp\htdocs\front\conx.php';
$db = $database;

class User {
    private $conn;
    private $table = "users";

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->conn = $db;
    }



    public function getByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    
    // Get all users
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get user by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new user (including password)
    public function create($firstname, $lastname, $email, $role, $password) {
        // Hash the password before saving it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table . " (firstname, lastname, email, role, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$firstname, $lastname, $email, $role, $hashedPassword]);
    }

    // Update user details (including password if provided)
    public function update($id, $firstname, $lastname, $email, $role, $password = null) {
        if ($password) {
            // If password is provided, hash it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE " . $this->table . " SET firstname = ?, lastname = ?, email = ?, role = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$firstname, $lastname, $email, $role, $hashedPassword, $id]);
        } else {
            $query = "UPDATE " . $this->table . " SET firstname = ?, lastname = ?, email = ?, role = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$firstname, $lastname, $email, $role, $id]);
        }
    }

  

    public function deleteByEmail($email) {
        $query = "DELETE FROM " . $this->table. " WHERE email = :email";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the email parameter
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            return true; 
        }
        return false; 
    }
}

















