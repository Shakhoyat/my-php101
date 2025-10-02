<?php
session_start();

// Include database functions
require_once 'database.php';

$uploadDir = 'uploads/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate inputs
    if ($username && $email && $phone) {

        // Check if email already exists in database
        if (emailExists($email)) {
            $_SESSION['error'] = "Email address already exists. Please use a different email.";
        } else {

            $imagePath = null;

            // Handle file upload if image is provided
            if (isset($_FILES['contact_image']) && $_FILES['contact_image']['error'] === UPLOAD_ERR_OK) {
                // Ensure directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imageName = time() . "_" . basename($_FILES['contact_image']['name']);
                $uploadFilePath = $uploadDir . $imageName;

                if (move_uploaded_file($_FILES['contact_image']['tmp_name'], $uploadFilePath)) {
                    $imagePath = $uploadFilePath;
                } else {
                    $_SESSION['error'] = "Error uploading image.";
                }
            }

            // Insert contact into database if no upload errors
            if (!isset($_SESSION['error'])) {
                $contactId = insertContact($username, $email, $phone, $imagePath);

                if ($contactId) {
                    $_SESSION['success'] = "Contact '$username' created successfully! (ID: $contactId)";
                    header("Location: index_mysql.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Error creating contact in database.";
                }
            }
        }
    } else {
        $_SESSION['error'] = "Please fill all required fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contact - MySQL Version</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .required {
            color: red;
        }

        .info-box {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>➕ Create New Contact (MySQL)</h1>

        <div class="info-box">
            <h4>💡 MySQL Learning Notes:</h4>
            <ul>
                <li>✅ Data is stored in MySQL database table</li>
                <li>🔒 Uses prepared statements to prevent SQL injection</li>
                <li>📧 Email uniqueness is enforced by database</li>
                <li>🆔 Auto-incremented ID is assigned to each contact</li>
                <li>📅 Timestamps are automatically managed</li>
            </ul>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">❌ <?php echo $_SESSION['error'];
                                                unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">👤 Username <span class="required">*</span></label>
                <input type="text" name="username" id="username" placeholder="Enter username" required
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">📧 Email <span class="required">*</span></label>
                <input type="email" name="email" id="email" placeholder="Enter email address" required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <small style="color: #666;">Must be unique - no duplicates allowed</small>
            </div>

            <div class="form-group">
                <label for="phone">📱 Phone <span class="required">*</span></label>
                <input type="text" name="phone" id="phone" placeholder="Enter phone number" required
                    value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="contact_image">🖼️ Contact Image (Optional)</label>
                <input type="file" name="contact_image" id="contact_image" accept="image/*">
                <small style="color: #666;">Supported formats: JPG, PNG, GIF</small>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">💾 Create Contact</button>
                <a href="index_mysql.php" class="btn btn-secondary">❌ Cancel</a>
            </div>
        </form>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666;">
            <p>🔗 <strong>Database Operation:</strong> INSERT INTO contacts (username, email, phone, image_path) VALUES (?, ?, ?, ?)</p>
        </div>
    </div>
</body>

</html>