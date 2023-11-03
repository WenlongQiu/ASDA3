<?php
    session_start();
    $Username_From_Session = $_SESSION['username'];
    $User_Role = $_SESSION['is_staff'];
    // If user not logged in, redirect to index
    if ($Username_From_Session == "" || $User_Role == "0") {
        header('Location: index.html');
        exit();
    }

    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);
    $conn->close();
?>
<html>
    <head>
        <title>View All Order History</title>
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
            <h2>View All Order History</h2>
            <?php if ($result->num_rows > 0): ?>
                <table style="text-align: center">
                    <tr>
                        <th width="150px">Username</th>
                        <th width="150px">Order Time</th>
                        <th width="150px">Dish Name</th>
                        <th width="150px">Dish Quantity</th>
                        <th width="150px">Payment Information</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php
                        // Convert JSON data to PHP associative array
                        $items = json_decode($row['items'], true);
                        foreach ($items as $item) {
                            $dishname = $item['dishname'];
                            $quantity = $item['quantity'];
                            echo "<tr>
                                    <td>".$row['username']."</td>
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
