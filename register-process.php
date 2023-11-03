<?php
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
    //This site is for client so it will be a set variable
    $is_staff = 0;
    if (containsSqlInjection($username)) {
        echo "SQL Injection detected!";
        echo "<br><button style='width: 150px;'><a href='register.php' style='text-decoration: none;color: black;'>Go Back</a></button>";
    } else {
        //SQL Process
        $sql = "INSERT INTO user (username, password, is_staff) VALUES ('$username', '$password', '$is_staff')";
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        if (mysqli_query($conn, $sql)) {
            header('Location: login.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>