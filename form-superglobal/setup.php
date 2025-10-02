<?php

/**
 * Database Setup File
 * This file creates the database and table if they don't exist
 */

require_once 'config.php';

/**
 * Create database if it doesn't exist
 */
function createDatabase()
{
    // Connect without selecting a database first
    $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8 COLLATE utf8_general_ci";

    if ($connection->query($sql) === TRUE) {
        echo "Database created successfully or already exists<br>";
    } else {
        echo "Error creating database: " . $connection->error . "<br>";
    }

    $connection->close();
}

/**
 * Create contacts table
 */
function createContactsTable()
{
    $conn = createConnection();

    // SQL to create contacts table
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        image_path VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'contacts' created successfully or already exists<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    closeConnection($conn);
}

/**
 * Setup everything (database and table)
 */
function setupDatabase()
{
    echo "<h2>Setting up Database...</h2>";
    createDatabase();
    createContactsTable();
    echo "<h3>Database setup completed!</h3>";
}

// If this file is accessed directly, run the setup
if (basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"])) {
?>
<!DOCTYPE html>
<html>

<head>
    <title>Database Setup</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }
    </style>
</head>

<body>
    <h1>Contact Management - Database Setup</h1>
    <?php
        setupDatabase();
        ?>
    <p><a href="index.php">Go to Contact Management</a></p>
</body>

</html>
<?php
}
?>