<?php
require_once 'config.php';

// Get all contacts
function getAllContacts()
{
    $conn = connect();
    $result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
    $contacts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    $conn->close();
    return $contacts;
}

// Add new contact
function addContact($name, $email, $phone, $image = null)
{
    $conn = connect();

    $sql = "INSERT INTO contacts (name, email, phone, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $image);

    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $success;
}

// Delete contact
function deleteContact($id)
{
    $conn = connect();

    $sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $success;
}

// Check if email exists
function emailExists($email)
{
    $conn = connect();

    $sql = "SELECT id FROM contacts WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;

    $stmt->close();
    $conn->close();

    return $exists;
}
