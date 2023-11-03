<?php
    session_start();
    $username = $_SESSION['username'];
    error_reporting(E_ERROR | E_PARSE);
    // If user logged in, redirect to landing page
    if ($username == "") {
        header('Location: index.html');
        exit(); // Added exit to ensure script stops executing
    }
    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    $sql = "SELECT * FROM orders WHERE username='$username'";
    $result = $conn->query($sql);
    $conn->close();
?>
<html>
    <head>
        <title>My Order History</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .center{
            padding-top: 20px;
            width: 800px;
            margin: 0 auto;
        }
        button{
            width: 150px;
            height: 30px;
        }
    </style>
    <body>
        <div class="center">
            <h2>My Order History</h2>
            <?php if ($result->num_rows > 0): ?>
                <table style="text-align: center">
                    <tr>
                        <th width="200px">Order Time</th>
                        <th width="200px">Dish Name</th>
                        <th width="200px">Dish Quantity</th>
                        <th width="200px">Payment Information</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php
                        // Convert JSON data to PHP associative array
                        $items = json_decode($row['items'], true);
                        foreach ($items as $item) {
                            $dishname = $item['dishname'];
                            $quantity = $item['quantity'];
                            echo "<tr>
                                            <td>".$row['time']."</td>
                                            <td>$dishname</td>
                                            <td>$quantity</td>
                                            <td>".$row['status']."</td>
                                          </tr>";
                        }
                        ?>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
            <a href="landing.php"><button>Back</button></a>
        </div>
    </body>
</html>
