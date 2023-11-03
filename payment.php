<?php
    session_start();
    $Username_From_Session = $_SESSION['username'];
    error_reporting(E_ERROR | E_PARSE);

    // If user logged in, redirect to landing page
    if ($Username_From_Session == "") {
        header('Location: index.html');
        exit(); // Added exit to ensure script stops executing
    }

    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // When User hit Pay now button
    if (isset($_POST['pay_now'])) {
        // Check if payment_time session is set
        if (isset($_SESSION['payment_time'])) {
            $payment_time = $_SESSION['payment_time'];
            // Assuming you have a table named 'orders' with columns: id, starters, status
            $sql = "UPDATE orders SET status='paid' WHERE time='$payment_time'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Thank you for your payment!'); window.location.href = 'landing.php';</script>";
            }
            // Remove payment_time session
            unset($_SESSION['payment_time']);
        }
    }
    $conn->close();
?>

<html lang="en">
    <head>
        <title>Make Payment</title>
        <style>
            body {
                margin: 0;
                text-align: center;
            }

            .Paynow {
                width: 200px;
                height: 100px;
                margin: 0 auto;
                padding-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="Paynow">
            <h1>Pay Now!</h1>
            <form method="post" onsubmit="return validateForm()">
                <div>
                    <input type="number" id="Bankcard" name="Bankcard" required placeholder="Bank Card Number"><br>
                    <input type="password" id="CVN" name="CVN" required placeholder="CVN"><br>
                    <button type="submit" name="pay_now">Pay Now!</button>
                </div>
            </form>
        </div>
        <script>
            function validateForm() {
                var bankCard = document.getElementById("Bankcard").value;
                var cvn = document.getElementById("CVN").value;
                if (bankCard.length !== 16 || cvn.length !== 3) {
                    alert("Please enter a valid Bank Card Number (16 digits) and CVN (3 digits).");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
