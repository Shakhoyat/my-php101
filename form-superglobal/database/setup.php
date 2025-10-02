<?php
require_once 'config.php';

// Create database and table
function setupDatabase()
{
    // First, connect without database to create it
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    $conn->query($sql);
    $conn->close();

    // Now connect to the database and create table
    $conn = connect();

    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql)) {
        echo "✅ Database and table ready!";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
}

// Run setup if accessed directly
if (basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"])) {
?>
    <h1>Database Setup</h1>
    <?php
    setupDatabase();
    ?>
    <br><br>
    <a href="../index.php">Go to Contacts</a>
<?php
}
?>