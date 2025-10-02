<?php

/**
 * Database Helper Functions
 * This file contains all database operations for contacts
 */

require_once 'config.php';

/**
 * Insert a new contact into database
 * 
 * @param string $username Contact's username
 * @param string $email Contact's email
 * @param string $phone Contact's phone
 * @param string $imagePath Path to contact's image
 * @return bool|int Returns contact ID if successful, false if failed
 */
function insertContact($username, $email, $phone, $imagePath = null)
{
    $conn = createConnection();

    // Prepare SQL statement to prevent SQL injection
    $sql = "INSERT INTO contacts (username, email, phone, image_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        closeConnection($conn);
        return false;
    }

    // Bind parameters (s = string)
    $stmt->bind_param("ssss", $username, $email, $phone, $imagePath);

    if ($stmt->execute()) {
        $contactId = $conn->insert_id; // Get the ID of inserted record
        $stmt->close();
        closeConnection($conn);
        return $contactId;
    } else {
        echo "Error inserting contact: " . $stmt->error;
        $stmt->close();
        closeConnection($conn);
        return false;
    }
}

/**
 * Get all contacts from database
 * 
 * @return array Array of all contacts
 */
function getAllContacts()
{
    $conn = createConnection();

    $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $contacts = [];
    if ($result && $result->num_rows > 0) {
        // Fetch all rows as associative array
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    closeConnection($conn);
    return $contacts;
}

/**
 * Get a single contact by ID
 * 
 * @param int $contactId Contact ID
 * @return array|null Contact data or null if not found
 */
function getContactById($contactId)
{
    $conn = createConnection();

    $sql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        closeConnection($conn);
        return null;
    }

    $stmt->bind_param("i", $contactId); // i = integer
    $stmt->execute();

    $result = $stmt->get_result();
    $contact = $result->fetch_assoc();

    $stmt->close();
    closeConnection($conn);

    return $contact;
}

/**
 * Update a contact
 * 
 * @param int $contactId Contact ID
 * @param string $username New username
 * @param string $email New email
 * @param string $phone New phone
 * @param string $imagePath New image path (optional)
 * @return bool True if successful, false if failed
 */
function updateContact($contactId, $username, $email, $phone, $imagePath = null)
{
    $conn = createConnection();

    if ($imagePath) {
        $sql = "UPDATE contacts SET username = ?, email = ?, phone = ?, image_path = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $phone, $imagePath, $contactId);
    } else {
        $sql = "UPDATE contacts SET username = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $phone, $contactId);
    }

    if (!$stmt) {
        closeConnection($conn);
        return false;
    }

    $success = $stmt->execute();
    $stmt->close();
    closeConnection($conn);

    return $success;
}

/**
 * Delete a contact
 * 
 * @param int $contactId Contact ID to delete
 * @return bool True if successful, false if failed
 */
function deleteContact($contactId)
{
    $conn = createConnection();

    $sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        closeConnection($conn);
        return false;
    }

    $stmt->bind_param("i", $contactId);
    $success = $stmt->execute();

    $stmt->close();
    closeConnection($conn);

    return $success;
}

/**
 * Check if email already exists (for validation)
 * 
 * @param string $email Email to check
 * @param int $excludeId Contact ID to exclude from check (for updates)
 * @return bool True if email exists, false if available
 */
function emailExists($email, $excludeId = null)
{
    $conn = createConnection();

    if ($excludeId) {
        $sql = "SELECT id FROM contacts WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $excludeId);
    } else {
        $sql = "SELECT id FROM contacts WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;

    $stmt->close();
    closeConnection($conn);

    return $exists;
}
