<html lang="en">
    <head>
        <title>Menu</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .Menu{
            width: 800px;
            margin: 0 auto;
        }
        img{
            width: 150px;
            height: 150px;
        }
        td{
            width: 200px;
            text-align: center;
        }
        button{
            width: 150px;
            height: 30px;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
    <body>
        <div class="Menu">
            <h1>Menu</h1>
            <?php
                error_reporting(E_ERROR | E_PARSE);
                session_start();
                $Username_From_Session = $_SESSION['username'];

                // If user logged in, redirect to landing page
                if ($Username_From_Session == "") {
                    header('Location: index.html');
                    exit(); // Added exit to ensure script stops executing
                }
                require_once 'database_config.php';
                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
                // Fetch menu items from the database
                $sql = "SELECT dishname, dishprice, dishquantity FROM menu";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th width: 150px;>Photo</th><th width: 150px;>Dish Name</th><th width: 150px;>Price</th><th width: 150px;>Quantity</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><img src='/img/" . $row["dishname"] . ".png'></td>";
                        echo "<td>" . $row["dishname"] . "</td>";
                        echo "<td>" . $row["dishprice"] . "</td>";
                        echo "<td>" . $row["dishquantity"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Sorry currently there are nothing in the menu.</p>";
                }
                $conn->close();
            ?>
            <button><a href="landing.php">Go Back</a></button>
        </div>
    </body>
</html>