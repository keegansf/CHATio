<?php 

include("config.php");

session_start();

if(isset($_SESSION['login_id'])) {
    $user_id = $_SESSION['login_id'];

    $sQuery = "SELECT fullName from account where id = ? LIMIT 1";

        $stmt = $conn->prepare($sQuery);
        $stmt -> bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($fullName);
        $stmt->store_result();

        if($stmt-> fetch()) {
            $session_fullName = $fullName;
            $stmt-> close();
            $conn->close();
        }
}

?>