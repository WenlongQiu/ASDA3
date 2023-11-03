<?php
    session_start();
    error_reporting(E_ERROR | E_PARSE);
    $Username_From_Session = $_SESSION['username'];

    // If user logged in, redirect to landing page
    if ($Username_From_Session == "") {
        header('Location: index.html');
        exit(); // Added exit to ensure script stops executing
    }
    if(isset($_POST['confirm_order'])){
        require_once 'database_config.php';
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        $Username_From_Session = $_SESSION['username'];
        $Payment_OK = "No";
        date_default_timezone_set('Australia/Sydney');
        $Time = date('Y-m-d H:i:s');
        $_SESSION['payment_time'] = $Time;
        $sql = "INSERT INTO orders (username, status, time, items) VALUES ('$Username_From_Session', '$Payment_OK','$Time', ?)";
        $stmt = $conn->prepare($sql);
        $items = json_encode($_SESSION['cart']);
        $stmt->bind_param("s", $items);
        $stmt->execute();
        $stmt->close();
        echo $sql;
        $conn->close();

        // Clear the cart and redirect to a confirmation page
        unset($_SESSION['cart']);
        header("Location: payment.php");
        exit();
    }
?>

<html lang="en">
    <head>
        <title>Checkout</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .ConfirmOrder{
            width: 600px;
            height: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        a{
            text-decoration: none;
            color: black;
        }
        form{
            padding-top: 20px;
        }
    </style>
    <body>
        <div class="ConfirmOrder">
            <h2>Confirm Order</h2>
            <h3>Items in Your Cart:</h3>
            <table style="text-align: center">
                <tr>
                    <th width="200px">Dish Name</th>
                    <th width="200px">Price</th>
                    <th width="200px">Number of Dishes</th>
                </tr>
                <?php
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        echo "<tr>
                                    <td>".$item['dishname']."</td>
                                    <td>".$item['dishprice']."</td>
                                    <td>".$item['quantity']."</td>
                                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Your cart is empty</td></tr>";
                }
                ?>
            </table>
            <form method="post">
                <input type="submit" name="confirm_order" value="Confirm Order">
                <button><a href="Ordering.php">Go Back to Order Page</a></button>
            </form>
        </div>
    </body>
</html>

