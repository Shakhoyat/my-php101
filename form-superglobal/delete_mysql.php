<?php
session_start();

// Include database functions
require_once 'database.php';

// Check if contact ID is provided and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid contact ID specified for deletion.";
    header("Location: index_mysql.php");
    exit();
}

$contactId = intval($_GET['id']);

// Get contact details before deletion (for confirmation message and image cleanup)
$contact = getContactById($contactId);

if (!$contact) {
    $_SESSION['error'] = "Contact not found in database.";
    header("Location: index_mysql.php");
    exit();
}

// Store contact name for confirmation message
$contactName = $contact['username'];

// Delete the image file if it exists
if (!empty($contact['image_path']) && file_exists($contact['image_path'])) {
    if (unlink($contact['image_path'])) {
        // Image deleted successfully
    } else {
        // Could not delete image file, but continue with database deletion
    }
}

// Delete contact from database
if (deleteContact($contactId)) {
    $_SESSION['success'] = "Contact '$contactName' (ID: $contactId) deleted successfully from database!";
} else {
    $_SESSION['error'] = "Error deleting contact from database.";
}

// Redirect back to the main page
header("Location: index_mysql.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleting Contact...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        .loading {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="loading">
        <h2>🗑️ Deleting Contact...</h2>
        <p>Please wait while we remove the contact from the database.</p>
        <p>You will be redirected automatically.</p>
    </div>

    <script>
        // Fallback redirect in case headers don't work
        setTimeout(function() {
            window.location.href = 'index_mysql.php';
        }, 2000);
    </script>
</body>

</html>