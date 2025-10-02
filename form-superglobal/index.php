<?php
session_start();
require_once 'database/functions.php';

$contacts = getAllContacts();
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Contacts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .contact {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }

        .btn-danger {
            background: #dc3545;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 3px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <h1>📞 My Contacts</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <a href="add.php" class="btn">➕ Add Contact</a>
    <a href="database/setup.php" class="btn">🔧 Setup Database</a>

    <h3>Total Contacts: <?= count($contacts) ?></h3>

    <?php if (empty($contacts)): ?>
        <p>No contacts yet. <a href="add.php">Add your first contact!</a></p>
    <?php else: ?>
        <?php foreach ($contacts as $contact): ?>
            <div class="contact">
                <h3><?= htmlspecialchars($contact['name']) ?></h3>
                <p>📧 <?= htmlspecialchars($contact['email']) ?></p>
                <p>📱 <?= htmlspecialchars($contact['phone']) ?></p>
                <p>📅 Added: <?= date('M j, Y', strtotime($contact['created_at'])) ?></p>

                <?php if ($contact['image'] && file_exists($contact['image'])): ?>
                    <img src="<?= $contact['image'] ?>" style="max-width: 100px; border-radius: 5px;">
                <?php endif; ?>

                <br><br>
                <a href="delete.php?id=<?= $contact['id'] ?>" class="btn btn-danger"
                    onclick="return confirm('Delete <?= htmlspecialchars($contact['name']) ?>?')">
                    🗑️ Delete
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>