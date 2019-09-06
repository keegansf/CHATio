<?php

session_start(); //starting the session

//if session exits, user will neither need to sign in again nor sign up
if(isset($_SESSION['login_id'])) {
    if(isset($_SESSION['pageStore'])) {
        $pageStore = $_SESSION['pageStore'];
        header("location: $pageStore");
    }
} 

if (isset($_POST['signUp'])) {
    if (empty($_POST['fullName']) || empty($_POST['email']) || empty($_POST['newPassword'])) {
        echo "Please fill out the required fields";
    }
    else {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $password = $_POST['newPassword'];
        $hash = $password_hash($password, PASSWORD_DEFAULT);

        include (config.php);

        $sQuery = "SELECT id, passowrd from account where email=? LIMIT 1";
        $iQuery = "INSERT Into account (fullName, email, password) values(?, ?, ?)";
        
        $stmt = $conn -> prepare($sQuery);
        $stmt -> bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        
        if($rnum==0) {
            $stmt->close();

            $stme = $conn->prpare($iQuery);
            $stme->bind_param("sss",$fullName,$email, $hash);
            if($stme->execute()) {
                echo "Registration success! Please login with your detail!";
            }
        
        }
        else{
            echo "Someone has already registered with ($email)";
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
    <title>Register</title>
</head>
<body>
    <div class="reg-container">
        <img src="images/logo.svg" alt="">
        <h2 class="header">Sign Up</h2>
        <p class="subheader reg-sub">Just a few details before you get started</p>
        <form action="" method="POST" class="signup-wrap" oninput="validatePassword()">
        <div class="input-wrap">
            <label class="label" for="name">
            Full Name
            </label>
            <input class="input name" type="text" required>
        </div>
        <div class="input-wrap">
            <label class="label" for="email">
            Email Address
            </label>
            <input class="input email" type="email" required>
        </div>
        <div class="input-wrap">
            <label class="label" for="password">
            Password
            </label>
            <input name="newPassword" id="newPass" class="input password" type="password" required>
        </div>
        <div class="input-wrap">
            <label class="label" for="password">
            Confirm Password
            </label>
            <input name="confirmPassword" id="confirmPass" class="input newpassword" type="password" required>
        </div>

        <button type="submit" class="btn signup">
            Sign Up
        </button>
        <div class="footer">
           Already have an account? <a href="login.php">Login</a>
        </div>
        </form>
        </div>
    </div>
    <script>
    function validatePassword () {
        if (newPass.value != confirmPass.value) {
            confirmPass.setCustomValidity('Passwords do not match');
        } else {
            confirm.Pass.setCustomValidity('');
        }
    }
</script>
</body>
</html>

