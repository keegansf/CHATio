<?php
    session_start(); //starting the session

    //if session exits, user will neither need to sign in again nor sign up
    if(isset($_SESSION['login_id'])) {
        if(isset($_SESSION['pageStore'])) {
            $pageStore = $_SESSION['pageStore'];
            header("location: $pageStore");
        }
    } 

    //Login in 
    if (isset($_POST['signIn'])) {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            echo "Username and password need to be filled";
        } else {
            $email = $_POST['email'];
            $password = $_POST['password'];

            include (config.php);

            $sQuery = "SELECT id, passowrd from account where email=? LIMIT 1";
            
            $stmt = $conn -> prepare($sQuery);
            $stmt -> bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $hash);
            $stmt->store_result();
            
            if($stmt->fetch()) {
                if(password_verify($passwprd, $hash)) {
                    $_SESSION['login_id'] = $id;
                    if (isset($_SESSION['pageStore'])) {
                        $pageStore = $_SESSION['pageStore'];
                    }
                    else {
                        $pageStore = "index.php";
                    }
                    header("location: $pageStore");
                    $stmt-> close();
                    $conn->close();
                }
                else{
                    echo "Invalid Username and Password";
                }
            
            }
            else{
                echo "Invalid Username and Password";
            }
            $stmt->close();
            $conn->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="login-wrap">
        <h2 class="header">Sign In</h2>
        <p class="subheader">Login to CHATio</p>
        <form action="" method="POST">
            <div class="input-wrap">
                <label class="label" for="email">
                Email Address
                </label>
                <input class="input" type="email" name="email" required>
            </div>
            <div class="input-wrap">
                <label class="label" for="password">
                Password
                </label>
                <input class="input" type="password" name="password" required>
            </div>
            <button type="submit" class="btn">
                Sign In
            </button>
            <div class="footer">
               Don't have an account?
           <a href="register.php">Sign up</a>
        </div>
        </form>
        </div>
        <img src="images/hero.png" alt="">
    </div>
</body>
</html>