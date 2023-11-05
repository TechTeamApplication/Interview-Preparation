<?php
class DatabaseConnectionManager {
    private static $instance;
    private $connection;

    private function __construct() {
        // Initialize and establish the database connection
        $this->connection = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnectionManager();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

$connectionManager = DatabaseConnectionManager::getInstance();
$connection = $connectionManager->getConnection();

// Now, you can use $connection to perform database operations

// Execute a SELECT query on the 'users' table
$query = 'SELECT * FROM users';

try {
    // Prepare the SQL statement
    $statement = $connection->prepare($query);

    // Execute the query
    $statement->execute();

    // Check if any rows were returned
    $rowCount = $statement->rowCount();
    
    if ($rowCount > 0) {
        // Fetch the results as an associative array
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Process the results
        foreach ($results as $row) {
            echo 'User ID: ' . $row['user_id'] . '<br>';
            echo 'Username: ' . $row['username'] . '<br>';
            echo 'Email: ' . $row['email'] . '<br>';
            // Add more fields as needed
            echo '<hr>';
        }
    } else {
        echo 'No records found in the "users" table.';
    }
} catch (PDOException $e) {
    // Handle any database errors
    echo 'Error: ' . $e->getMessage();
}


?>