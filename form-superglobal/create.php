<?php
session_start();
$uploadDir = 'uploads/';
$contactsFile = 'contacts.json';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($username && $email && $phone && isset($_FILES['contact_image'])) {
        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = time() . "_" . basename($_FILES['contact_image']['name']);
        $uploadFilePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['contact_image']['tmp_name'], $uploadFilePath)) {
            // Load existing contacts or create empty array
            $contacts = file_exists($contactsFile) ? json_decode(file_get_contents($contactsFile), true) : [];

            // Add new contact
            $contacts[] = [
                'username' => $username,
                'email' => $email,
                'phone' => $phone,
                'image' => $uploadFilePath
            ];

            // Save back to JSON file
            file_put_contents($contactsFile, json_encode($contacts, JSON_PRETTY_PRINT));

            $_SESSION['success'] = "Contact '$username' created successfully!";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Error uploading image.";
        }
    } else {
        $_SESSION['error'] = "Please fill all fields and select an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contact</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        max-width: 300px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        margin-left: 10px;
        text-decoration: none;
        display: inline-block;
    }

    .alert {
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    </style>
</head>

<body>
    <h1>Create New Contact</h1>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter username" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
            <label for="contact_image">Contact Image:</label>
            <input type="file" name="contact_image" id="contact_image" accept="image/*" required>
        </div>

        <button type="submit" class="btn">Create Contact</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>

</html>