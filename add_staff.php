<html lang="en">
    <head>
        <title>Add Staff</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .center{
            width: 250px;
            margin: 0 auto;
        }
        input{
            width: 100%;
        }
        a{
            text-decoration: none;
            color: black;
        }
        button{
            width: 150px;
        }
    </style>
    <body>
        <div class="center">
            <h3>Add Staff</h3>
            <form action="add_staff-process.php" method="post">
                Username: <input type="text" name="username" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" value="Register" style="margin-top: 10px; width: 150px">
            </form>
            <a href="landing.php"><button>Back</button></a>
        </div>
    </body>
</html>