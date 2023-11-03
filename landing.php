<?php
    session_start();
    $Username_From_Session = $_SESSION['username'];
    $User_Role = $_SESSION['is_staff'];

    // If user not logged in, redirect to index
    if ($Username_From_Session == "") {
        header('Location: index.html');
        exit(); // Added exit to ensure script stops executing
    }

    $User_CSS_Control_Admin = "style='display:none;'"; // Admin buttons initially hidden
    $User_CSS_Control_Customer = "style='display:block;'"; // Customer buttons initially visible

    // If user is an admin, adjust CSS
    if ($User_Role == 1) {
        $User_CSS_Control_Admin = "style='display:block;'"; // Admin buttons visible
        $User_CSS_Control_Customer = "style='display:none;'"; // Customer buttons hidden
    }
?>

<html lang="en">
    <head>
        <title>Welcome</title>
    </head>
    <style>
        body{
            text-align: center;
        }
        button{
            width: 140px;
            height: 30px;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
    <body>
        <h1>Welcome <?php echo $Username_From_Session ?>!</h1>
        <!-- visible to staff users -->
        <div class="Staff" <?php echo $User_CSS_Control_Admin ?>>
            <button><a href="dish_management.php">Dish Management</a></button>
            <button><a href="add_staff.php">Add Staff</a></button>
            <button><a href="viewallorder.php">View All Order</a></button>
            <button><a href="logout.php">Log out</a></button>
        </div>
        <!-- visible to customer users -->
        <div class="Customer" <?php echo $User_CSS_Control_Customer ?>>
            <button><a href="search_dish.php">Search Dish</a></button>
            <button><a href="FAQ.php">FAQ</a></button>
            <button><a href="Ordering.php">Order Now</a></button>
            <button><a href="MyOrder.php">View My Order</a></button>
            <button><a href="MyInfo.php">View My Info</a></button>
            <button><a href="menu.php">Menu</a></button>
            <button><a href="logout.php">Log out</a></button>
        </div>
    </body>
</html>
