<?php
    // Start Session
    session_start();
    // Destroy Session
    session_destroy();
    // Set message
    $_SESSION['message'] = 'Logout OK!';
?>
<html lang="en">
    <head>
        <title>Logout</title>
    </head>
    <style>
        body{
            margin: 0;
        }
        .message{
            text-align: center;
        }
    </style>
    <body>
        <?php
            if(isset($_SESSION['message'])) {
                echo '<div id="message">'.$_SESSION['message'].'</div>';
                unset($_SESSION['message']);
                echo '<script>
                                setTimeout(function() {
                                    window.location.href = "index.html";
                                }, 3000);
                              </script>';
            } else {
                header("Location: index.html");
                exit();
            }
        ?>
    </body>
</html>