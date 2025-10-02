<?php
session_start();

// Check if contact ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid contact ID specified for deletion.";
    header("Location: index.php");
    exit();
}

// Get contact ID
$id = intval($_GET['id']);

// Load contacts from the file
$contactsFile = 'contacts.json';
$contacts = [];

if (file_exists($contactsFile)) {
    $contacts = json_decode(file_get_contents($contactsFile), true);
} else {
    $_SESSION['error'] = "No contacts file found.";
    header("Location: index.php");
    exit();
}

// Check if the contact exists
if (!isset($contacts[$id])) {
    $_SESSION['error'] = "Contact not found.";
    header("Location: index.php");
    exit();
}

// Get contact name for confirmation message
$contactName = $contacts[$id]['username'];

// Delete the image file if it exists
if (!empty($contacts[$id]['image']) && file_exists($contacts[$id]['image'])) {
    unlink($contacts[$id]['image']);
}

// Remove the contact from the array
unset($contacts[$id]);

// Reindex the array to maintain sequential indices
$contacts = array_values($contacts);

// Save the updated contacts array back to the file
file_put_contents($contactsFile, json_encode($contacts, JSON_PRETTY_PRINT));

// Set success message
$_SESSION['success'] = "Contact '$contactName' deleted successfully.";

// Redirect back to the index page
header("Location: index.php");
exit();
