 <?php

    $uploadDir = 'uploads/';
    $contactsFile = 'contacts.json';

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate inputs
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

        // Validate inputs
        if ($username && $email && $phone && isset($_FILES['contact_image'])) {
            //Ensure directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            // Handle file upload
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

                echo "Contact Added: $username ($email, $phone)<br>";
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid input. Please fill all fields correctly.<br>";
        }
    }

    ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>

 <body>
     <form action="" method="POST" enctype="multipart/form-data">
         <label for="username">Username:</label>
         <input type="text" name="username" placeholder="Username">
         <br>
         <label for="email">Email:</label>
         <input type="email" name="email" placeholder="Email">
         <br>
         <label for="phone">Phone:</label>
         <input type="text" name="phone" placeholder="Phone">
         <br>
         <label for="contact_image">Contact Image:</label>
         <input type="file" name="contact_image" accept="image/*">
         <br>
         <button type="submit">Submit</button>
     </form>
 </body>

 </html>