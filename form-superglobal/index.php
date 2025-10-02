<?php
session_start();
$contactFile = 'contacts.json';
$contacts = file_exists($contactFile) ? json_decode(file_get_contents($contactFile), true) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .contact-card {
        border: 1px solid #ccc;
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        margin: 5px;
        text-decoration: none;
        border-radius: 3px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .alert {
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    </style>
</head>

<body>
    <h1>Contact Management System</h1>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success'];
                                            unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <a href="create.php" class="btn btn-primary">Create New Contact</a>
    <hr>

    <?php if (empty($contacts)): ?>
    <p>No contacts found. <a href="create.php">Create your first contact</a></p>
    <?php else: ?>
    <?php foreach ($contacts as $index => $contact): ?>
    <div class="contact-card">
        <h2><?php echo htmlspecialchars($contact['username']); ?></h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($contact['phone']); ?></p>
        <?php if (!empty($contact['image']) && file_exists($contact['image'])): ?>
        <img src="<?php echo htmlspecialchars($contact['image']); ?>"
            alt="<?php echo htmlspecialchars($contact['username']); ?>" style="max-width:200px; border-radius: 5px;">
        <?php else: ?>
        <p><em>No image available.</em></p>
        <?php endif; ?>
        <br>
        <a href="delete.php?id=<?php echo $index; ?>" class="btn btn-danger"
            onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>