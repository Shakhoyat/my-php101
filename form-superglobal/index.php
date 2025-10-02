 <?php
    echo "<pre>";
    var_dump($_FILES);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        // echo "Username: " . htmlspecialchars($username) . "<br>";
        // echo "Email: " . htmlspecialchars($email) . "<br>";
        // echo "Phone: " . htmlspecialchars($phone) . "<br>";
        // echo "Password: " . htmlspecialchars($password) . "<br>";
        if ($username && $email && $phone && $password) {
            echo "Username: $username<br>";
            echo "Email: $email<br>";
            echo "Phone: $phone<br>";
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
         <label for="contact Image">Contact Image:</label>
         <input type="file" name="contact_image" accept="image/*">
         <br>
         <label for="password">Password:</label>
         <input type="password" name="password" placeholder="Password">
         <br>
         <button type="submit">Submit</button>
     </form>
 </body>

 </html>