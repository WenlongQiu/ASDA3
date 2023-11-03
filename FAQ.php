<?php
    //Session_Start for later user
    session_start();
    $Username_From_Session = $_SESSION['username'];
    // If user not logged in, redirect to index
    if ($Username_From_Session == "") {
        header('Location: index.html');
        exit(); // Added exit to ensure script stops executing
    }
?>
<html lang="en">
    <head>
        <title>FAQ</title>
    </head>
    <style>
        body{
            margin: 0;
        }
        .center{
            width: 700px;
            margin: 0 auto;
            padding-top: 20px;

        }
        h1{
            text-align: center;
        }
        button{
            width: 150px;
            height: 30px;
        }
        .buttonclass{
            width: 100%;
            text-align: center;
        }
    </style>
    <body>
        <div class="center">
            <h1>FAQ Help Center</h1>
            <h3>FAQ 1: How can I track the status of my order?</h3>
            <h3>Answer:</h3>
            <p>You can easily track the status of your order by logging into your account and navigating to the "Order History" section. There, you'll find a list of all your recent orders along with their current status, such as "Processing," "Shipped," or "Delivered." You'll also receive email notifications with updates on your order status.</p>
            <h3>FAQ 2: What payment methods are accepted for my purchases?</h3>
            <h3>Answer:</h3>
            <p>We accept a variety of payment methods to provide you with convenience and security. You can make payments using major credit and debit cards, including Visa, MasterCard, and American Express. Additionally, we offer the option to pay through secure digital wallets like PayPal and Apple Pay. Rest assured, all transactions are encrypted and processed securely to safeguard your financial information.</p>
            <div class="buttonclass">
                <a href="landing.php"><button>Back</button></a>
            </div>
        </div>
    </body>
</html>