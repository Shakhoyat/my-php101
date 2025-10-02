 <?php
    echo '<pre>';
    var_dump($_SERVER, $_GET, $_POST);
    echo '</pre>';
    ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>

 <body>
     <form action="" method="get"></form>
     <label for="username">Username:</label>
     <input type="text" name="username" placeholder="Username">
     <br>
     <label for="password">Password:</label>
     <input type="password" name="password" placeholder="Password">
     <br>
     <button type="submit">Submit</button>
     </form>
 </body>

 </html>