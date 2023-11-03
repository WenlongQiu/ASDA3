<html lang="en">
    <head>
        <title>Login</title>
    </head>
    <style>
        body{
            margin: 0;
        }
        .center{
            width: 200px;
            margin: 0 auto;
        }
        input{
            width: 100%;
            float: right;
        }
        button{
            width: 200px;
        }
        button a{
            text-decoration: none;
            color: black;
        }
    </style>
    <body>
        <div class="center">
            <h3>Login</h3>
            <form action="login_process.php" method="post">
                Username: <input type="text" name="username" required><br>
                Password: <input type="password" name="password" required><br>
                Is Staff? <input type="checkbox" name="is_staff"><br>
                <input type="submit" value="Login">
            </form>
            <button><a href="index.html">Go Back</a></button>
        </div>
    </body>
</html>