<html lang="en">
    <head>
        <title>Search Dishes</title>
    </head>
    <style>
        body{
            margin: 0;
        }
        .View-Point{
            margin: 0 auto;
            width: 400px;
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
        <div class="View-Point">
            <h2>Search for Dishes</h2>
            <form method="post" action="">
                Keyword: <input type="text" name="keyword">
                <input type="submit" name="search" value="Search">
            </form>
            <?php
                //Session Start
                session_start();
                //For Database Connection
                require_once 'database_config.php';
                //Check Is UserLogin
                $Username_From_Session = $_SESSION['username'];
                if ($Username_From_Session == "") {
                    header('Location: index.html');
                    exit();
                }
                //Set UP MySQL Connection
                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
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
                if(isset($_POST['search'])) {
                    $keyword = $_POST['keyword'];
                    if (containsSqlInjection($keyword)) {
                        echo "<p>SQL Injection detected!</p>";
                    } else if ($keyword != "") {
                        $sql = "SELECT * FROM menu WHERE dishname LIKE '%$keyword%'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<p>Dish Name: " . $row['dishname'] . " - Price: " . $row['dishprice'] . " - Quantity: " . $row['dishquantity'] . "</p>";
                            }
                        } else {
                            echo "<p>There's no current keywords in our database</p>";
                        }
                    } else {
                        echo "<p>Please enter keywords into the text-area</p>";
                    }
                }
                $conn->close();
            ?>
            <br>
            <button><a href="landing.php">Go Back</a></button>
        </div>
    </body>
</html>
