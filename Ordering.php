<?php
    //Session Start
    session_start();
    //If Session Payment_time is there not allowed to make another order for that user.
    if (isset($_SESSION['payment_time'])) {
        // Redirect to another page with an alert message
        header("Refresh: 5; URL=payment.php"); // Redirect after 5 seconds
        echo "You have already made a order,Please pay. Redirecting you...";
        exit(); // Stop further execution
    }
    //SQL Connection
    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    //Listen event add
    if (isset($_GET['add'])) {
        //Get User Add Dish item
        $dishname = $_GET['add'];
        //SQL Process
        $sql = "SELECT * FROM menu WHERE dishname='$dishname'";
        $result = $conn->query($sql);
        //If dish appear in database and collect information form the database
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            //This is item information that are going to add in to the session later
            $item = array(
                'dishname' => $row['dishname'],
                'dishprice' => $row['dishprice'],
                'quantity' => 1
            );
            //Session Process
            if (isset($_SESSION['cart'][$dishname])) {
                $_SESSION['cart'][$dishname]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$dishname] = $item;
            }
        }
    }
    //Listen event remove item from session
    if (isset($_GET['remove'])) {
        $dishname = $_GET['remove'];
        if (isset($_SESSION['cart'][$dishname])) {
            unset($_SESSION['cart'][$dishname]);
        }
    }
    //Clear Shopping cart
    if (isset($_GET['clear'])) {
        unset($_SESSION['cart']);
    }
    //For Display Information in the menu
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);
    $conn->close();
?>

<html lang="en">
    <head>
        <title>Shop Now！</title>
    </head>
    <style>
        body{
            margin:0;
            text-align: center;
        }
        .center{
            width: 800px;
            margin: 0 auto;
            margin-top: 20px;
        }
    </style>
    <body>
        <div class="center">
            <div>
                <h2>Menu</h2>
                <table style="text-align: center">
                    <tr>
                        <th width="200px">Dish Name</th>
                        <th width="200px">Price</th>
                        <th width="200px">Quantity</th>
                        <th width="200px">Add to Cart</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                        <td>".$row["dishname"]."</td>
                                        <td>".$row["dishprice"]."</td>
                                        <td>".$row["dishquantity"]."</td>
                                        <td><a href='?add=".$row["dishname"]."'><button>Add to Cart</button></a></td>
                                    </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>
            </div>
            <div>
                <h2>Shopping Cart</h2>
                <table style="text-align: center">
                    <tr>
                        <th width="200px">Dish Name</th>
                        <th width="200px">Price</th>
                        <th width="200px">Number of Dish</th>
                        <th width="200px">Remove</th>
                    </tr>
                    <?php
                        //Display all things in Shopping cart
                        if (!empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                echo "<tr>
                                            <td>".$item['dishname']."</td>
                                            <td>".$item['dishprice']."</td>
                                            <td>".$item['quantity']."</td>
                                            <td><a href='?remove=".$item['dishname']."'><button>Remove</button></a></td>
                                        </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'><p>Currently, Your Shopping Cart is empty!</p></td></tr>";
                        }
                    ?>
                </table>
                <p>Total Price:
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $total += $item['dishprice'] * $item['quantity'];
                        }
                    }
                    echo $total." AUD";
                    ?>
                </p>
                <a href="landing.php"><button>Go Back</button></a>
                <a href='?clear=true'><button>Clear Cart</button></a>
                <?php
                // Check if the cart is not empty before displaying the checkout button
                if (!empty($_SESSION['cart'])) {
                    echo "<a href='checkout.php'><button>Checkout</button></a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>
