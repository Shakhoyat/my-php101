<?php

/**
 * Database Configuration File
 * This file contains all database connection settings
 */

// Database connection parameters
define('DB_HOST', 'localhost');     // Database server (usually localhost)
define('DB_USERNAME', 'root');      // Database username (default is 'root' for XAMPP)
define('DB_PASSWORD', '');          // Database password (empty for XAMPP)
define('DB_NAME', 'contact_management'); // Database name

/**
 * Function to create database connection using MySQLi
 * MySQLi is newer and more secure than old mysql functions
 */
function createConnection()
{
    // Create connection using MySQLi
    $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check if connection failed
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Set charset to utf8 for proper character encoding
    $connection->set_charset("utf8");

    return $connection;
}

/**
 * Function to close database connection
 */
function closeConnection($connection)
{
    if ($connection) {
        $connection->close();
    }
}

/**
 * Test database connection
 */
function testConnection()
{
    $conn = createConnection();
    if ($conn) {
        echo "Database connected successfully!<br>";
        echo "Server info: " . $conn->server_info . "<br>";
        closeConnection($conn);
        return true;
    }
    return false;
}
