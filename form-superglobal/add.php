<?php
session_start();
require_once 'database/functions.php';

if ($_POST) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Simple validation
    if (empty($name) || empty($email) || empty($phone)) {
        $_SESSION['error'] = "Please fill all fields!";
    } elseif (emailExists($email)) {
        $_SESSION['error'] = "Email already exists!";
    } else {
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = time() . '_' . $_FILES['image']['name'];
            $imagePath = $uploadDir . $fileName;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        // Add to database
        if (addContact($name, $email, $phone, $imagePath)) {
            $_SESSION['message'] = "Contact '$name' added successfully!";
            header('Location: simple_index.php');
            exit;
        } else {
            $_SESSION['error'] = "Failed to add contact!";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 500px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: #6c757d;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 3px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <h1>➕ Add New Contact</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Name *</label>
        <input type="text" name="name" required>

        <label>Email *</label>
        <input type="email" name="email" required>

        <label>Phone *</label>
        <input type="text" name="phone" required>

        <label>Photo (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">💾 Save Contact</button>
        <a href="simple_index.php" class="btn-secondary">❌ Cancel</a>
    </form>

    <hr>
    <h4>💡 Learning Notes:</h4>
    <ul>
        <li>Form data goes to database using SQL INSERT</li>
        <li>Email uniqueness checked before saving</li>
        <li>Files uploaded to 'uploads/' folder</li>
        <li>Success/error messages using PHP sessions</li>
    </ul>
</body>

</html>