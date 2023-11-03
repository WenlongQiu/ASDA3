<?php
    session_start();
    $Username_From_Session = $_SESSION['username'];
    $User_Role = $_SESSION['is_staff'];
    $editValue = "";
    // Request database connection data from config file
    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // If user not logged in, redirect to index
    if ($Username_From_Session == "") {
        header('Location: index.html');
        exit();
    }
    if ($User_Role == "0") {
        header('Location: index.html');
        exit();
    }

    if (isset($_GET['edit'])) {
        $editValue = $_GET['edit'];
    } else {
        header('Location: index.html');
        exit();
    }
    //SQL injection checking function
    function containsSqlInjection($input) {
        $sqlInjectionPatterns = [
            '/\b(SELECT|UPDATE|DELETE|INSERT|ALTER|DROP|CREATE|UNION|JOIN|WHERE)\b/i',
            '/\b(AND|OR|NOT|XOR)\b/i',
            '/\b(UNION\s+ALL)\b/i'
        ];
        foreach ($sqlInjectionPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }
        return false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        if (containsSqlInjection($price) || containsSqlInjection($quantity)) {
            echo "SQL Injection detected!";
        } else {
            // SQL query to update price and quantity based on dish name
            $sql = "UPDATE menu SET dishprice='$price', dishquantity='$quantity' WHERE dishname='$editValue'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Updated Successfully');</script>";
                sleep(2);
                header('Location: dish_management.php');
            }
        }
    }
?>

<html>
    <head>
        <title>Edit dish</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .center{
            width: 300px;
            margin: 0 auto;
        }
    </style>
    <body>
        <div class="center">
            <h3>Edit Dish</h3>
            <form method="post" action="">
                Dish Name: <?php echo $editValue;?><br>
                Price: <input type="text" name="price" required><br>
                Quantity: <input type="text" name="quantity" required><br>
                <input type="submit" name="edit" value="Edit Dish">
            </form>
            <a href="dish_management.php"><button>Back</button></a>
        </div>
    </body>
</html>
