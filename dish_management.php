<?php
    // Session_Start for later user
    session_start();
    $Username_From_Session = $_SESSION['username'];
    $User_Role = $_SESSION['is_staff'];
    // If user not logged in, redirect to index
    if ($Username_From_Session == "") {
        header('Location: index.html');
        exit();
    }
    if($User_Role == "0"){
        header('Location: index.html');
        exit();
    }
    // Request database connection data from config file
    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    // Function to sanitize user input
    function sanitize($input) {
        return htmlspecialchars(strip_tags($input));
    }
    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle add dish
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
        if (isset($_POST['add'])) {
            $dishName = sanitize($_POST['dish_name']);
            $price = sanitize($_POST['price']);
            $quantity = sanitize($_POST['quantity']);
            if (containsSqlInjection($dishName) || containsSqlInjection($price) || containsSqlInjection($quantity) ) {
                echo "SQL Injection detected!";
            } else {
                // Add Input Check to avoid system error
                if (!empty($dishName) && is_numeric($price) && is_numeric($quantity)) {
                    $stmt = $conn->prepare("INSERT INTO menu (dishname,dishprice, dishquantity) VALUES (?, ?, ?)");
                    $stmt->bind_param("sii", $dishName, $price, $quantity);
                    if ($stmt->execute()) {
                        echo "<script>alert('Add Successfully');</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $stmt->close();
                } else {
                    echo "Invalid input!";
                }
            }
        }
        // Handle delete dish
        if (isset($_POST['delete'])) {
            $dishNameDel = sanitize($_POST['dishname']);
            $stmt = $conn->prepare("DELETE FROM menu WHERE dishname=?");
            $stmt->bind_param("s", $dishNameDel);
            if ($stmt->execute()) {
                echo "<script>alert('Deleted Successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $stmt->close();
        }
    }
    // Get dish information from the database
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);
?>

<html>
    <head>
        <title>Dish Management</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .center{
            width: 800px;
            margin: 0 auto;
            padding-top: 20px;
        }
        form{
            width:300px;
            margin: 0 auto;
        }
        td{
            text-align: center;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
    <body>
        <div class="center">
            <h3>Add Dish</h3>
            <form method="post" action="">
                Dish Name: <input type="text" name="dish_name" required><br>
                Price: <input type="text" name="price" required><br>
                Quantity: <input type="text" name="quantity" required><br>
                <input type="submit" name="add" value="Add Dish">
            </form>
            <br>
            <br>
            <br>
            <h3>Delete Dish</h3>
            <table>
                <tr>
                    <th width="200">Dish Name</th>
                    <th width="200">Price</th>
                    <th width="200">Quantity</th>
                    <th width="200">Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['dishname'] . "</td>";
                        echo "<td>" . $row['dishprice'] . "</td>";
                        echo "<td>" . $row['dishquantity'] . "</td>";
                        echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='dishname' value='" . $row['dishname'] . "'>
                        <button><a href='editdish.php?edit=". $row['dishname']."'>Edit</button>
                        <input type='submit' name='delete' value='Delete'>
                    </form>
                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No dishes found</td></tr>";
                }
                ?>
            </table>
        </div>
        <a href="landing.php"><button>Back</button></a>
    </body>
</html>
