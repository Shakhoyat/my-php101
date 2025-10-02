<?php
session_start();

// Include database functions
require_once 'database.php';

// Get all contacts from database
$contacts = getAllContacts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management - MySQL Version</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .contact-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            background: #fafafa;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .alert {
            padding: 15px;
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stats {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📞 Contact Management System (MySQL)</h1>
            <div>
                <a href="setup.php" class="btn btn-success">🔧 Setup Database</a>
                <a href="create_mysql.php" class="btn btn-primary">➕ Add New Contact</a>
            </div>
        </div>

        <div class="stats">
            <strong>📊 Total Contacts: <?php echo count($contacts); ?></strong>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">✅ <?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">❌ <?php echo $_SESSION['error'];
                                                unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($contacts)): ?>
            <div style="text-align: center; padding: 50px;">
                <h3>📭 No contacts found</h3>
                <p>Start building your contact list by adding your first contact!</p>
                <a href="create_mysql.php" class="btn btn-primary">➕ Create First Contact</a>
            </div>
        <?php else: ?>
            <?php foreach ($contacts as $contact): ?>
                <div class="contact-card">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <h2>👤 <?php echo htmlspecialchars($contact['username']); ?></h2>
                            <p><strong>📧 Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
                            <p><strong>📱 Phone:</strong> <?php echo htmlspecialchars($contact['phone']); ?></p>
                            <p><strong>🆔 ID:</strong> <?php echo $contact['id']; ?></p>
                            <p><strong>📅 Added:</strong> <?php echo date('M j, Y g:i A', strtotime($contact['created_at'])); ?></p>
                            <?php if ($contact['updated_at'] !== $contact['created_at']): ?>
                                <p><strong>✏️ Updated:</strong> <?php echo date('M j, Y g:i A', strtotime($contact['updated_at'])); ?></p>
                            <?php endif; ?>
                        </div>

                        <div style="text-align: center; margin-left: 20px;">
                            <?php if (!empty($contact['image_path']) && file_exists($contact['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($contact['image_path']); ?>"
                                    alt="<?php echo htmlspecialchars($contact['username']); ?>"
                                    style="max-width:150px; max-height:150px; border-radius: 8px; object-fit: cover;">
                            <?php else: ?>
                                <div style="width:150px; height:150px; background:#ddd; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#666;">
                                    🖼️ No Image
                                </div>
                            <?php endif; ?>

                            <div style="margin-top: 10px;">
                                <a href="delete_mysql.php?id=<?php echo $contact['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($contact['username']); ?>?')">
                                    🗑️ Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666;">
            <p>💡 <strong>Learning Note:</strong> This system now uses MySQL database instead of JSON files!</p>
            <p>🔗 Database: <?php echo DB_NAME; ?> | Table: contacts | Fields: id, username, email, phone, image_path, created_at, updated_at</p>
        </div>
    </div>
</body>

</html>