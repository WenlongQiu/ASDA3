<?php
    error_reporting(E_ERROR | E_PARSE);
    session_start();
    $Username_From_Session = $_SESSION['username'];
    // If user logged in, redirect to landing page
    if ($Username_From_Session != "") {
        header('Location: landing.php');
        exit(); // Added exit to ensure script stops executing
    }
?>
<html lang="en">
    <head>
        <title>Register</title>
    </head>
    <style>
        body{
            margin: 0;
        }
        .Register{
            width: 250px;
            margin: 0 auto;
        }
        .Register h1{
            text-align: center;
        }
        input{
            width: 100%;
        }
    </style>
    <body>
        <div class="Register">
            <h1>Register</h1>
            <form action="register-process.php" method="post">
                Username: <input type="text" name="username" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" value="Register" style="margin-top: 10px">
            </form>
        </div>
    </body>
</html>