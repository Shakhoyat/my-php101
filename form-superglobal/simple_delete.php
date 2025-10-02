<?php
session_start();
require_once 'database/functions.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No contact selected!";
    header('Location: simple_index.php');
    exit;
}

$id = (int)$_GET['id'];

if (deleteContact($id)) {
    $_SESSION['message'] = "Contact deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete contact!";
}

header('Location: simple_index.php');
exit;
?>