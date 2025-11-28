<!doctype html>
<html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Zaloguj się</title>

        <link rel="stylesheet" href="/Chat/dist/css/main.css">
        <link rel="stylesheet" href="/Chat/dist/css/login.css">

    </head>

    <body>

        <main class="container">
            <form action="" method="post" class="form">
                <label for="username">Nazwa:</label>
                <input type="text" name="username" id="username">
                <label for="password">Hasło:</label>
                <input type="password" name="password" id="password">
                <input type="submit" value="Zaloguj się">
            </form>
        </main>
        
        <?php

            if(isset($_POST["username"]) && isset($_POST["password"]))
            {
                if(is_string($_POST["username"]) && is_string($_POST["password"]))
                {
                    $username = $_POST["username"];
                    $password = $_POST["password"]; 

                    $db = new mysqli("localhost","root","","chat");

                    if($db->connect_error)
                    {
                        die("Nie działa ". $db->connect_error);
                    }
                    else
                    {

                    }

                }
                else
                {

                }
                
            }



        ?>

    </body>

</html>