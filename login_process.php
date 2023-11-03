<?php
    //Session_Start for later user
    session_start();
    //Request database connection data from config file
    require_once 'database_config.php';
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
    //Get user input from front page
    $username = $_POST['username'];
    $password = $_POST['password'];
    $is_staff = isset($_POST['is_staff']) ? 1 : 0;
    //Check SQL Injection
    if (containsSqlInjection($username)) {
        echo "SQL Injection detected!";
    } else {
        //SQL Process
        $sql = "SELECT * FROM user WHERE username='$username'";
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        $result = mysqli_query($conn, $sql);
        //If there are result comming in
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            //If password match
            if ($password == $row['password']) {
                //If Is_Staff Detail match
                if ($is_staff == $row['is_staff']) {
                    $_SESSION['username'] = $username;
                    $_SESSION['is_staff'] = $is_staff;
                    //If match then jump to landing page for details
                    header('Location: landing.php');
                } else {
                    echo "Invalid Input";
                    echo "<br><button style='width: 150px;'><a href='login.php' style='text-decoration: none;color: black;'>Go Back</a></button>";
                }
            } else {
                echo "Username not found or password is not correct";
                echo "<br><button style='width: 150px;'><a href='login.php' style='text-decoration: none;color: black;'>Go Back</a></button>";
            }
        }
        else {
            echo "Username not found";
            echo "<br><button style='width: 150px;'><a href='login.php' style='text-decoration: none;color: black;'>Go Back</a></button>";
        }
        mysqli_close($conn);
    }
?>
